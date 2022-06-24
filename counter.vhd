----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 14.06.2022 14:24:44
-- Design Name: 
-- Module Name: counter - Behavioral
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

entity counter is
    Port ( clk : in STD_LOGIC;
           resetcpt : in STD_LOGIC;
           enable : in STD_LOGIC;
           counter_out : out std_logic );
    end counter;

architecture Behavioral of counter is
constant  MyValCpthz: std_logic_vector( 23 downto 0) := "100110001001011010000000";
signal count : std_logic_vector(23 downto 0);

begin
Mycounter : process (resetCpt, clk)
    begin   
        if(resetCpt = '1') then
            count <= (others => '0'); 
        elsif (rising_edge(clk)) then 
            if( MyValCpthz = count) then
                count <= (others => '0');
                counter_out <= '1';
            else
                count <= count + 1; 
                counter_out <= '0'; 
            end if; 
        end if; 
    end process;
      

end Behavioral;

