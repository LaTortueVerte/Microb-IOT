----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 05.07.2022 10:17:23
-- Design Name: 
-- Module Name: TestLedCpnt - Behavioral
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
use IEEE.std_logic_unsigned.All;

-- Uncomment the following library declaration if using
-- arithmetic functions with Signed or Unsigned values
--use IEEE.NUMERIC_STD.ALL;

-- Uncomment the following library declaration if instantiating
-- any Xilinx leaf cells in this code.
--library UNISIM;
--use UNISIM.VComponents.all;

entity TestLedCpnt is
    Port ( clk : in std_logic ;
           TestBtn : in STD_LOGIC;
           TestLed : out STD_LOGIC;
           TestLedClk : out std_logic
           );
end TestLedCpnt;

architecture Behavioral of TestLedCpnt is

constant  MyValCpt: std_logic_vector(5 downto 0) := "111110"; --"100110001001011010000000"; -- 10.000.000 // 10 sec 
signal count : std_logic_vector(5 downto 0) := "000000";

begin

MyLedBehavior : process (clk, TestBtn)
    begin 
        if (rising_edge(clk)) then 
            if( MyValCpt = count) then
                count <= (others => '0');
                TestLedclk  <= '1';
            else
                count <= count + 1; 
                TestLedClk  <= '0'; 
            end if;
        end if; 
        if (TestBtn ='1') then 
            TestLed <= '1';
        else
            TestLed <= '0';
        end if;
    end process;
end Behavioral;
