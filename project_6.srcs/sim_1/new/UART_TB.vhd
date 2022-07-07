----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 06.07.2022 23:16:41
-- Design Name: 
-- Module Name: UART_TB - Behavioral
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

entity UART_TB is
--  Port ( );
end UART_TB;

architecture Behavioral of UART_TB is
component UART_SCOM is port
(CLOCK : in std_logic;
     TX_pin : out std_logic; -- voir fonctionnement dans uart tx 
     RX_pin : in std_logic;
	 SW_pins :in std_logic_vector(7 downto 0); -- byte gen
	 id_pins : out std_logic_vector(3 downto 0); -- code map 
	 code_pins : out std_logic_vector(3 downto 0) -- code map 
	 );
end component;
signal CLOCK,AlgTX_pin, AlgRX_pin: std_logic; 
signal AlgSw_pin: std_logic_vector(7 downto 0); 
signal Algid_pin, AlgCode_pin: std_logic_vector(3 downto 0); 
begin
My_UART_Under_Test: UART_SCOM port map(
        CLOCK => CLOCK,
        TX_pin => AlgTX_pin ,
        RX_pin => AlgRX_pin,
        SW_pins => AlgSw_pin,
        id_pins => Algid_pin ,
        code_pins => AlgCode_pin );

test: process
 begin
    CLOCK <= '0'; 
    wait FOR 1 ms;
    CLOCK <='1'; 
    wait for 1 ms; 
    
    AlgSW_pin<="00000010";
            

    
end process; 


end Behavioral;
