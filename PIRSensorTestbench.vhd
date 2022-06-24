----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 21.06.2022 11:24:57
-- Design Name: 
-- Module Name: PIRSensorTestbench - Behavioral
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
use IEEE.numeric_std.all;
use IEEE.std_logic_unsigned.all;


-- Uncomment the following library declaration if using
-- arithmetic functions with Signed or Unsigned values
--use IEEE.NUMERIC_STD.ALL;

-- Uncomment the following library declaration if instantiating
-- any Xilinx leaf cells in this code.
--library UNISIM;
--use UNISIM.VComponents.all;

entity PIRSensorTestbench is
--  Port ( );
end PIRSensorTestbench;

architecture PIRSensorTestbench_Arch of PIRSensorTestbench is

component PIRSensor is
    Port ( reset : in std_logic ;
           clk : in std_logic ;
           counter_In : in std_logic ;
           enable : in STD_LOGIC;
           counter_out : out std_logic_vector (9 downto 0);
           PIROut : in STD_LOGIC;
           PiRRes : out STD_LOGIC);
           
end component;

signal sreset, sclk, scounter_In, sPIROut, sPiRRes : std_logic := '0';
signal senable                                 : std_logic := '1';
signal scounter_out                            : std_logic_vector(9 downto 0) := (others => '0');

begin

MyComponentTestbench : PIRSensor

port map(
    reset => sreset,
    clk => sclk,
    counter_In => scounter_In,
    enable => senable,
    counter_out => scounter_out,
    PIROut => sPIROut,
    PiRRes => sPiRRes
    );
    
MyStimulus_Proc : process
begin 
    sclk <= '1';
    wait for 100 ns;
    sclk <= '0';
    wait for 100 ns;
    
    end process;

end PIRSensorTestbench_Arch;
