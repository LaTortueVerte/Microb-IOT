----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 29.06.2022 14:56:50
-- Design Name: 
-- Module Name: ControlAlgo_testbench - Behavioral
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

entity ControlAlgo_testbench is
  
end ControlAlgo_testbench;

architecture Behavioral of ControlAlgo_testbench is
component ControlAlgo is

end component;



    signal sclk : std_logic;

    signal sreset : std_logic := '0';
    signal sPIROut : std_logic := '0';
    signal sPIRes : std_logic := '0';
    
    signal sresetCpt, sbresetCpt : std_logic :='0';
    signal sEnable, sbEnable : std_logic :='0';
    signal sCounter_out, sbCounter_out : std_logic := '0'; 
    
    signal sBuzEnable_out : std_logic := '0';    
    signal sBuzEnable_in : std_logic := '0';    
    
    signal sTX_pin : std_logic := '0';
    signal sRX_pin : std_logic := '0';  
    signal sSW_pins : std_logic_vector(7 downto 0) :=(others => '0');
	signal sid_pins :  std_logic_vector(3 downto 0) :=(others => '0');
	signal scode_pins : std_logic_vector(3 downto 0) :=(others => '0');

begin
    

MyStimulus_Proc : process
begin 
    sclk <= '0'; 
    WAIT FOR 1 ps;
    sclk <= '1';
    WAIT FOR 1 ps;
    
    if( now = 10 ps) then 
        sPIRes <= '1';
    end if;
    if( now = 100 ps) then 
        sPIRes <= '0';
    end if;
    
    end process;


end Behavioral;
