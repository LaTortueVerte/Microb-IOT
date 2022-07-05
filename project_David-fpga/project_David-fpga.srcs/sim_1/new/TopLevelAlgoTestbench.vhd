----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 04.07.2022 13:20:29
-- Design Name: 
-- Module Name: TopLevelAlgoTestbench - Behavioral
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

entity TopLevelAlgoTestbench is
--  Port ( );
end TopLevelAlgoTestbench;

architecture Behavioral of TopLevelAlgoTestbench is

component TopLevelControlAlgo is
Port (
    clk : in std_logic;
    TOPPIRSensorState : in std_logic;
    TOPAlgBuzzer_out : out std_logic;
    --TOPAlgBuzzer_in : in std_logic;
    TOPresetPir : in std_logic ;
    TOPAlgPIRes : out std_logic ;
    TOPAlgTX_pin : out std_logic ;
    TOPAlgid_pin : out std_logic_vector(3 downto 0) ;
    TOPAlgCode_pin : out std_logic_vector(3 downto 0);
    --AlgSw_pin : in std_logic_vector(7 downto 0);
    TestBtn : in STD_LOGIC;
    TestLed : out STD_LOGIC;
    TestLedClk : out std_logic
    );
end component ;
     
signal clk, TOPAlgBuzzer_in, TOPPIRSensorState, TOPAlgBuzzer_out, TOPresetPir, TOPAlgPIRes, TOPAlgTX_pin, TOPAlgBuzzOut, TestLed, TestBtn, TestLedClk : std_logic := '0';
signal TOPAlgid_pin, TOPAlgCode_pin : std_logic_vector(3 downto 0) := (others => '0');

begin
MyComponentTestBenchTopLevel : TopLevelControlAlgo

port map (
    clk => clk,
    TOPPIRSensorState => TOPPIRSensorState,
    TOPAlgBuzzer_out => TOPAlgBuzzer_out, 
    TOPresetPir => TOPresetPir, 
    TOPAlgPIRes => TOPAlgPIRes, 
    TOPAlgTX_pin => TOPAlgTX_pin, 
    TOPAlgid_pin => TOPAlgid_pin,
    TOPAlgCode_pin => TOPAlgCode_pin, 
    --TOPAlgBuzzer_in => TOPAlgBuzzer_in,
    TestBtn => TestBtn,
    TestLed => TestLed,
    TestLedClk => TestLedClk
    );
    
MyStimulus_Proc : process
begin 
    clk <= '0'; 
    WAIT FOR 1 ps;
    clk <= '1';
    WAIT FOR 1 ps;
    
    if ( now = 4 ps ) then
        TOPresetPir  <= '1'; 
    end if;
    
    if ( now = 6 ps ) then
        TOPresetPir  <= '0'; 
    end if;
    
    if ( now = 100 ps ) then
        TOPPIRSensorState  <= '1'; 
    end if;
    
    if ( now = 1000 ps ) then
        TOPPIRSensorState  <= '0'; 
    end if;
    
    if ( now = 1100 ps ) then
        TOPPIRSensorState  <= '1'; 
    end if;
    if ( now = 1200 ps ) then
        TOPPIRSensorState  <= '0'; 
    end if;
    
    if ( now = 106 ps ) then
        TestBtn   <= '0'; 
    end if;
    
    if ( now = 200 ps ) then
        TestBtn   <= '1'; 
    end if;
    
end process;
end Behavioral;
