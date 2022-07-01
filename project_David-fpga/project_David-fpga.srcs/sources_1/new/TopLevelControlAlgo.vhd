----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 01.07.2022 16:46:00
-- Design Name: 
-- Module Name: TopLevelControlAlgo - Behavioral
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

entity TopLevelControlAlgo is
    port( 
        clk : in std_logic;
        TOPPIRSensorState : in std_logic;
        TOPAlgBuzzer_out : out std_logic;
        TOPresetPir : in std_logic ;
        TOPAlgPIRes : out std_logic ;
        TOPAlgTX_pin : out std_logic ;
        TOPAlgid_pin : out std_logic_vector(3 downto 0) ;
        TOPAlgCode_pin : out std_logic_vector(3 downto 0) ;
        --AlgSw_pin : in std_logic_vector(7 downto 0);
        TOPAlgBuzzOut : out std_logic
        );
end entity TopLevelControlAlgo;

architecture Behavioral of TopLevelControlAlgo is

component ControlALgo
    port(
        clk : in std_logic;
        
        PIRSensorState : in std_logic;
        resetPir : out std_logic ;
        AlgPIRes : out std_logic ;
        
        AlgBuzzer_in : out std_logic ;
        AlgBuzzer_out : out std_logic;
        
        AlgresetCpt : out std_logic ;
        AlgenableCpt : out std_logic;
        AlgoutCpt : out std_logic;
        
        AlgbresetCpt : out std_logic ;
        AlgbenableCpt : out std_logic;
        AlgboutCpt : out std_logic;
        
        
        AlgTX_pin : out std_logic ;
        AlgRX_pin : out std_logic;  
        Algid_pin : out std_logic_vector(3 downto 0) ;
        AlgCode_pin : out std_logic_vector(3 downto 0) ;
        AlgSw_pin : out std_logic_vector(7 downto 0);
        AlgBuzzOut : out std_logic
    );
end component;

component counter
    port(
        clk : in STD_LOGIC;
        resetCpt : in STD_LOGIC;
        enable : in STD_LOGIC;
        counter_out : out std_logic); 
    end component;

-- component PIR sensor initialisation
    
component PIRSensor
    port (
       reset : in std_logic ;
       clk : in std_logic ;
       PIROut : in STD_LOGIC;
       PIRes: out STD_LOGIC);
    end component;
    
-- component Buzzer actor initialisation

component Buzzer
    port(
        BuzEnable_in : in std_logic;
        BuzEnable_out : out std_logic;
        clk : in std_logic
  );
end component;

component UART_SCOM
    port(
     CLOCK : in std_logic;
     TX_pin : out std_logic;
     RX_pin : in std_logic;
	 SW_pins :in std_logic_vector(7 downto 0);
	 id_pins : out std_logic_vector(3 downto 0);
	 code_pins : out std_logic_vector(3 downto 0)
	 );
end component ;

    
    signal PIRSensorState :  std_logic;
    signal resetPir : std_logic ;
    signal AlgPIRes : std_logic ;
    
    signal AlgBuzzer_in : std_logic ;
    signal AlgBuzzer_out : std_logic;
    
    signal AlgresetCpt : std_logic ;
    signal AlgenableCpt : std_logic;
    signal AlgoutCpt : std_logic;
    
    signal AlgbresetCpt : std_logic ;
    signal AlgbenableCpt : std_logic;
    signal AlgboutCpt : std_logic;
    
    
    signal AlgTX_pin : std_logic ;
    signal AlgRX_pin : std_logic;  
    signal Algid_pin : std_logic_vector(3 downto 0) ;
    signal AlgCode_pin : std_logic_vector(3 downto 0) ;
    signal AlgSw_pin : std_logic_vector(7 downto 0);

begin

CptCounter: counter PORT MAP(
        clk => clk,
        resetCpt => AlgresetCpt  ,
        enable => Algenablecpt,
        counter_out => AlgoutCpt
    );
    
BuzCounter: counter PORT MAP(
        clk => clk,
        resetCpt => AlgbresetCpt  ,
        enable => AlgbenableCpt,
        counter_out => AlgboutCpt
    );

RESPIRSensor: PIRSensor PORT MAP(
        clk => clk,
        reset => resetPir,
        PIROut => PIRSensorState,
        PIRes => AlgPIRes
    );
    
BuzActor : Buzzer PORT MAP(
        BuzEnable_in => AlgBuzzer_in,
        BuzEnable_out => AlgBuzzer_out,
        clk => clk
        );
        
UART_Raspi : UART_SCOM PORT MAP(
        CLOCK => clk,
        TX_pin => AlgTX_pin ,
        RX_pin => AlgRX_pin,
        SW_pins => AlgSw_pin,
        id_pins => Algid_pin ,
        code_pins => AlgCode_pin 
        );
        
ControlALgoComp : ControlAlgo Port MAP (
    clk => clk,

    PIRSensorState => PIRSensorState,
    resetPir => resetPir,
    AlgPIRes => AlgPIRes,
    
    AlgBuzzer_in => AlgBuzzer_in,
    AlgBuzzer_out => AlgBuzzer_out,
    
    AlgresetCpt => AlgresetCpt,
    AlgenableCpt => AlgenableCpt,
    AlgoutCpt => AlgoutCpt,
    
    AlgbresetCpt => AlgbresetCpt,
    AlgbenableCpt => AlgenableCpt,
    AlgboutCpt => AlgoutCpt,
    
    AlgTX_pin => AlgTX_pin,
    AlgRX_pin => AlgRX_pin,
    Algid_pin => Algid_pin,
    AlgCode_pin => AlgCode_pin,
    AlgSw_pin => AlgSw_pin);

end Behavioral;
