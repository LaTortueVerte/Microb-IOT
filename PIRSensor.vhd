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
    Port ( reset : in std_logic ;
           clk : in std_logic ;
           counter_In : in std_logic ;
           enable : in STD_LOGIC;
           counter_out : out std_logic_vector (9 downto 0);
           PIROut : in STD_LOGIC;
           PiRRes : out STD_LOGIC);
           
end PIRSensor;


architecture Behavioral of PIRSensor is
    component modcounter
    port(
        clk : in STD_LOGIC;
        resetcpt : in STD_LOGIC;
        enable : in STD_LOGIC;
        counter_out : out std_logic_vector (9 downto 0));
    end component;
    
   
   --- signals for the counter behavior 
   
   signal resetcpt : std_logic :='0';
   signal myEnable : std_logic :='1';
   signal myCounter_out : std_logic_vector  := (others => '0');
   
   signal MyPiRRes : std_logic :='0' ;
   
begin

    counterInst01: modcounter PORT MAP(
        clk => clk,
        resetcpt => resetcpt  ,
        enable => myEnable,
        counter_out => myCounter_out
        
        
    );
    
    MyPIRContol : process (clk, reset, PIROut)
	begin
	   if (reset = '1') then 
	       PIRRes <= '0';
       end if;
       if rising_edge(clk) then
        if (PIROut ='1') then
            PiRRes <='0';
        else
            PiRRes <='0';
        end if;
    end if;
	end process;
	


end Behavioral;