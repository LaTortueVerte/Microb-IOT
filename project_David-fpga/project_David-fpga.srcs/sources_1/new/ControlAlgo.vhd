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

    
end entity ControlAlgo;

architecture Behavioral of ControlAlgo is

-- component counter initialisation
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
    
    signal clk : std_logic;

    signal reset : std_logic := '0';
    signal PIROut : std_logic := '0';
    signal PIRes : std_logic := '0';
    
    signal resetCpt, bresetCpt : std_logic :='0';
    signal Enable, bEnable : std_logic :='0';
    signal Counter_out, bCounter_out : std_logic; 
    
    signal BuzEnable_out : std_logic;    
    signal BuzEnable_in : std_logic;    
    
    signal TX_pin : std_logic;
    signal RX_pin : std_logic;  
    signal SW_pins : std_logic_vector(7 downto 0);
	signal id_pins :  std_logic_vector(3 downto 0);
	signal code_pins : std_logic_vector(3 downto 0);
	
begin

CptCounter: counter PORT MAP(
        clk => clk,
        resetCpt => resetCpt  ,
        enable => enable,
        counter_out => counter_out
    );
    
BuzCounter: counter PORT MAP(
        clk => clk,
        resetCpt => bresetCpt  ,
        enable => benable,
        counter_out => bcounter_out
    );

RESPIRSensor: PIRSensor PORT MAP(
        clk => clk,
        reset => reset,
        PIROut => PIROut,
        PIRes => PIRes
    );
    
BuzActor : Buzzer PORT MAP(
        BuzEnable_in => BuzEnable_in,
        BuzEnable_out => BuzEnable_out,
        clk => clk
        );
        
UART_Raspi : UART_SCOM PORT MAP(
        CLOCK => clk,
        TX_pin => TX_pin,
        RX_pin => RX_pin,
        SW_pins => SW_pins,
        id_pins => id_pins,
        code_pins => code_pins
        );
        

    MyAlgoBehavior : process( clk) 
        begin
        if( PIRes = '1' and rising_edge(clk) and bCounter_out = '0' and bEnable = '0') then -- If PIRSensor UP and the buzzer counter is not working or has been already activated
            enable <= '1'; -- lancement du compteur
            if( Counter_out = '1') then 
                enable <= '0';
            end if;
        elsif( PIRes = '0' and rising_edge(clk)) then
            enable <= '0';
            resetCpt <='0';
            -- BuzEnable_in <= '0';
        end if;
        if(Counter_out = '1' and rising_edge(clk)) then -- if first counter up // launch of all actions
            BuzEnable_in <= '1'; -- Start of buzzer 
            bEnable <= '1'; -- Start of counter buzzer 
            if(bCounter_out = '1') then -- if buzzer counter end 
                 BuzEnable_in <= '0'; -- Stop of buzzer
                 bEnable <= '0';
            end if;
        end if;
        if(bCounter_out = '1' and PIRes = '0') then 
            bCounter_out <= '0';
        end if;
        end process; 
end Behavioral;
