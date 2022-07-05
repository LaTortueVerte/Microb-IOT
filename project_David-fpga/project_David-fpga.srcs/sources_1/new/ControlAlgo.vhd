----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 29.06.2022 14:50:32
-- Design Name: 
-- Module Name: ControlAlgo - Behavioral
-- Project Name: 
-- Target Devices: 
-- Tool Versions: 
-- Description: 
-- 
-- Dependencies: 
-- 
-- Revision:
-- Revision 0.01 - File Created
-- Additional Comments:
-- 
----------------------------------------------------------------------------------


library IEEE;
use IEEE.STD_LOGIC_1164.ALL;

-- Uncomment the following library declaration if using
-- arithmetic functions with Signed or Unsigned values
--use IEEE.NUMERIC_STD.ALL;

-- Uncomment the following library declaration if instantiating
-- any Xilinx leaf cells in this code.
--library UNISIM;
--use UNISIM.VComponents.all;

entity ControlAlgo is
    port( 
        clk : in std_logic;
        
        PIRSensorState : in std_logic := '0';
        resetPir : in std_logic := '0';
        AlgPIRes : out std_logic := '0';
        
        AlgBuzzer_in : out std_logic:= '0' ;
        AlgBuzzer_out : out std_logic:= '0';
        
        AlgresetCpt : out std_logic := '0';
        AlgOnCpt : out std_logic:= '0';
        AlgoutCpt : in std_logic:= '0';
        
        AlgbresetCpt : out std_logic := '0';
        AlgbOnCpt : out std_logic:= '0';
        AlgboutCpt : in std_logic:= '0';
        
        
        AlgTX_pin : out std_logic := '0';
        AlgRX_pin : out std_logic:= '0';  
        Algid_pin : out std_logic_vector(3 downto 0) ;
        AlgCode_pin : out std_logic_vector(3 downto 0) ;
        AlgSw_pin : out std_logic_vector(7 downto 0)
        );
end entity ControlAlgo;

architecture Behavioral of ControlAlgo is

signal AlgenableCpt, AlgbenableCpt, buzCptMem : std_logic := '0';

begin


    MyAlgoBehavior : process(AlgoutCpt,PIRSensorState, clk, buzCptMem,AlgbenableCpt) 
        begin
        if( PIRSensorState  = '1' and rising_edge(clk) and buzCptMem = '0' and AlgbenableCpt = '0') then -- If PIRSensor UP and the buzzer counter is not working or has been already activated
            AlgresetCpt <= '0';
            AlgOnCpt <= '1'; -- lancement du compteur
            AlgenableCpt <= '1';
            if( AlgoutCpt = '1') then 
                AlgOnCpt <= '0';
                Algenablecpt <= '0';
                -- lancement d'un message pour l'uart
                AlgSw_pin <= "11111111";
            end if;
        elsif( PIRSensorState  = '0' and rising_edge(clk) and buzCptMem = '0') then
            AlgOnCpt <= '0';
            AlgSw_pin <= "00000000";
            Algenablecpt <= '0';
            AlgresetCpt <= '1';
            --AlgbenableCpt <= '0';
        end if;
        if(AlgoutCpt = '1' and rising_edge(clk) and buzCptMem = '0') then -- if first counter up // launch of all actions
            AlgBuzzer_in <= '1'; -- Start of buzzer 
            AlgbOnCpt <= '1';
            AlgbenableCpt <= '1'; -- Start of counter buzzer 
            if(AlgboutCpt = '1') then -- if buzzer counter end 
                 AlgbOnCpt <= '0';
                 AlgbenableCpt <= '0';
                 AlgBuzzer_in <= '0'; -- Stop of buzzer
                 buzCptMem <= '1'; -- variable wich tell if we already launch the buzzer 
                 AlgSw_pin <= "00000000";
                 
            end if;
        end if;
        if(AlgboutCpt = '1' and PIRSensorState = '0') then 
            buzCptMem <= '0';
        end if;
        
        end process; 
end Behavioral;
