----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 24.06.2022 10:52:41
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

architecture Behavioral of PIRSensorTestbench is
component PIRSensor is
Port (
           reset : in std_logic ;
           clk : in std_logic ;
            PIROut : in STD_LOGIC;
            PIRes: out STD_LOGIC; 
           enable : in STD_LOGIC;
           counter_all : out std_logic);
 end component; 
 
 signal sreset, sclk, sPIROut, sPiRRes : std_logic := '0';
signal senable                                 : std_logic := '1';
signal scounter_out                            : std_logic; 
begin
MyComponentTestbench : PIRSensor

port map(
    reset => sreset,
    clk => sclk,
    enable => senable,
    counter_all => scounter_out,
    PIROut => sPIROut,
    PiRes => sPiRRes
    );

MyStimulus_Proc : process
begin 
    sclk <= '1';
    sPIROut <='1';
    senable <='1';     
    scounter_out <='0'; 
    wait for 1000 ns;
     
    
    sclk <= '0';
    wait for 1000 ns;

    end process;
end Behavioral;