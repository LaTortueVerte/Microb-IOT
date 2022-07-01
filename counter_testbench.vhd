----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 24.06.2022 14:43:54
-- Design Name: 
-- Module Name: counter_testbench - Behavioral
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

entity counter_testbench is
--  Port ( );
end counter_testbench;

architecture Behavioral of counter_testbench is
component counter
Port ( clk : in STD_LOGIC;
           resetcpt : in STD_LOGIC;
           enable : in STD_LOGIC;
           counter_out : out std_logic );
          end component;
          
   signal clk :std_logic; 
   signal resetCpt : std_logic :='0';
   signal myEnable : std_logic :='1';
   signal myCounter_out : std_logic; 
   
   signal PiRres : std_logic :='0' ; 
begin
 CptCounter: counter PORT MAP(
        clk => clk,
        resetCpt => resetCpt  ,
        enable => myEnable,
        counter_out => myCounter_out
    );
    
    Mycounter_test: process(clk, resetCpt)
    begin
    clk <= '1'; 
    resetCpt<='0'; 
    end process; 

end Behavioral;
