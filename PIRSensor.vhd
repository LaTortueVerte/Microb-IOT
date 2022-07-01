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
            PIRes: out STD_LOGIC; 
           enable : in STD_LOGIC;
           counter_all : out std_logic);
end PIRSensor;

architecture Behavioral of PIRSensor is
    component counter
    port(
        clk : in STD_LOGIC;
        resetCpt : in STD_LOGIC;
        enable : in STD_LOGIC;
        counter_out : out std_logic); 
    end component;
    
   
   --- signals for the counter behavior 
   
   signal resetCpt : std_logic :='0';
   signal myEnable : std_logic :='1';
   signal myCounter_out : std_logic; 
   
   signal MyPiRes : std_logic :='0' ;
begin

    CptCounter: counter PORT MAP(
        clk => clk,
        resetCpt => resetCpt  ,
        enable => myEnable,
        counter_out => myCounter_out
    );
    
    MyPirBehavior: process(myCounter_out, reset, clk)
    
        begin
        if(reset= '1') then 
        PIRes <= '0'; 
        
        else
              if (PiRout ='1' and  myCounter_out= '1') then
            PIRes <= '1'; 
              else
              PIRes <= '0';
                
              end if;
         end if; 
         counter_all <= myCounter_out; 
        end process; 

end Behavioral;
