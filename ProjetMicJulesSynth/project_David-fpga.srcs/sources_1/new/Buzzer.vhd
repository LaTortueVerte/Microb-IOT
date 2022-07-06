----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 27.06.2022 22:10:17
-- Design Name: 
-- Module Name: Buzzer - Behavioral
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

entity Buzzer is
  Port (
    BuzEnable_in : in std_logic;
    BuzEnable_out : out std_logic;
    clk : in std_logic
  );
end Buzzer;


architecture Behavioral of Buzzer is


begin
    
    MyBuzBehavior: process( clk, BuzEnable_in) 
        begin
        
          if (BuzEnable_in ='1' and rising_edge(clk)) then
            BuzEnable_out <= '1'; 
            
           end if;
           
           if (BuzEnable_in = '0' and rising_edge(clk)) then
             BuzEnable_out <= '0';
            
         end if; 
        end process; 

end Behavioral;
