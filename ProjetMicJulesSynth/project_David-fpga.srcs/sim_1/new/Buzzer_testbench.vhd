----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 29.06.2022 10:57:13
-- Design Name: 
-- Module Name: Buzzer_testbench - Behavioral
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

entity Buzzer_testbench is

end Buzzer_testbench;


architecture Behavioral of Buzzer_testbench is

component Buzzer is
--  Port ( );
    Port (
        BuzEnable_in : in std_logic;
        BuzEnable_out : out std_logic;
        clk : in std_logic
    );
end component;

signal BuzEnable_in, clk, BuzEnable_out : std_logic := '0' ;


begin

myComponentBuzTestbench : Buzzer

port map (
    BuzEnable_in => BuzEnable_in,
    BuzEnable_out => BuzEnable_out,
    clk => clk
    );
    
Mystimul_buz : process 
begin
    clk <= '0';
    wait for 1 ps; 
    clk <= '1';
    wait for 1 ps;
    if( now = 10 ps ) then 
        BuzEnable_in <= '1';
    end if;
     if( now = 50 ps ) then 
        BuzEnable_in <= '0';
    end if;
    
    end process;

end Behavioral;
