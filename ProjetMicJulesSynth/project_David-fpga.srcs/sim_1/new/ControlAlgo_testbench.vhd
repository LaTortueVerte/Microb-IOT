----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 29.06.2022 14:56:50
-- Design Name: 
-- Module Name: ControlAlgo_testbench - Behavioral
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

entity ControlAlgo_testbench is
  
end ControlAlgo_testbench;

architecture Behavioral of ControlAlgo_testbench is
component ControlAlgo is
    port( 
        clk : in std_logic;
        PIRSensorState : in std_logic;
        AlgBuzzer_out : out std_logic;
        AlgresetCpt : in std_logic ;
        AlgbresetCpt : in std_logic ;
        resetPir : in std_logic ;
        AlgPIRes : out std_logic ;
        AlgTX_pin : out std_logic ;
        Algid_pin : out std_logic_vector(3 downto 0) ;
        AlgCode_pin : out std_logic_vector(3 downto 0) ;
        --AlgSw_pin : in std_logic_vector(7 downto 0);
        AlgBuzzOut : out std_logic ;
        Algenablecpt : out std_logic
        );
end component;



    signal clk : std_logic;
    signal AlgBuzzer_out : std_logic := '0';
    signal PIRSensorState : std_logic := '0';
    signal AlgresetCpt : std_logic := '0';
    signal AlgbresetCpt : std_logic := '0';
    signal resetPir : std_logic := '0';
    signal AlgPIRes : std_logic := '0';
    signal AlgTX_pin : std_logic := '0';
    signal Algid_pin : std_logic_vector(3 downto 0) :=(others => '0');
    signal AlgCode_pin : std_logic_vector(3 downto 0) :=(others => '0');
    signal AlgBuzzOut : std_logic := '0';
    signal Algenablecpt : std_logic := '0';
    

    signal reset : std_logic := '0';
    --signal sPIROut : std_logic := '0';
    --signal sPIRes : std_logic := '0';
    
    signal resetCpt, bresetCpt : std_logic :='0';
    signal Enable, bEnable : std_logic :='0';
    signal Counter_out, bCounter_out : std_logic := '0'; 
    
    signal BuzEnable_out : std_logic := '0';    
    signal BuzEnable_in : std_logic := '0';    
    
    signal TX_pin : std_logic := '0';
    signal RX_pin : std_logic := '0';  
    signal SW_pins : std_logic_vector(7 downto 0) :=(others => '0');
	-- signal sid_pins :  std_logic_vector(3 downto 0) :=(others => '0');
	-- signal scode_pins : std_logic_vector(3 downto 0) :=(others => '0');



begin
    
MyComponentTestbenchAlgo : ControlAlgo

port map(
        clk => clk,
        PIRSensorState => PIRSensorState,
        AlgBuzzer_out => AlgBuzzer_out,
        AlgresetCpt => AlgresetCpt,
        AlgbresetCpt => AlgbresetCpt,
        resetPir => resetPir,
        AlgPIRes => AlgPIRes,
        AlgTX_pin => AlgTX_pin,
        Algid_pin => Algid_pin,
        AlgCode_pin => AlgCode_pin,
        --AlgSw_pin : in std_logic_vector(7 downto 0);
        AlgBuzzOut => AlgBuzzOut,
        Algenablecpt => Algenablecpt
        );
    

MyStimulus_Proc : process
begin 
    clk <= '0'; 
    WAIT FOR 1 ps;
    clk <= '1';
    WAIT FOR 1 ps;
    
    if( now = 10 ps) then 
        PIRSensorState  <= '1';
    end if;
    if( now = 600 ps) then 
        PIRSensorState  <= '0';
    end if;
    
    end process;


end Behavioral;
