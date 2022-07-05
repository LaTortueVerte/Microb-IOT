----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 14.06.2022 14:19:04
-- Design Name: 
-- Module Name: PIRSensor - Behavioral
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

entity PIRSensor is
    Port (
           reset : in std_logic ;
           clk : in std_logic ;
           PIROut : in STD_LOGIC;
           PIRes: out STD_LOGIC);
           
end PIRSensor;


architecture Behavioral of PIRSensor is
    
   
   
   
begin

    
    MyPIRContol : process (clk, reset, PIROut)
	begin
	
	   
       if (PIROut ='1' and rising_edge(clk)) then
           PiRes <='0';
           
       elsif ( PIROut = '0' and rising_edge(clk)) then 
           PiRes <='0';
        end if;
        
        if (reset = '1' and rising_edge(clk)) then 
	       PIRes <= '0';
       end if;
       
        
	end process;
	

end Behavioral;