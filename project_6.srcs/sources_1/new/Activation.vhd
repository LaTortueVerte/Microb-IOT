----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 06.07.2022 17:09:46
-- Design Name: 
-- Module Name: Activation - Behavioral
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

entity Activation is
Port (code_pin_in: in std_logic_vector(3 downto 0); 
    id_pin_in: in std_logic_vector; 
    active: out std_logic
 );
end Activation;

architecture Behavioral of Activation is
signal complete: std_logic_vector(7 downto 0); 

begin
process(code_pin_in, id_pin_in) is begin
complete <= code_pin_in & id_pin_in; 
if( complete="00000011") then
active <= '1'; 
end if; 
end process; 

end Behavioral;
