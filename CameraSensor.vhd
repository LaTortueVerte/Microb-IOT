----------------------------------------------------------------------------------
-- Company: 
-- Engineer: 
-- 
-- Create Date: 21.06.2022 11:19:23
-- Design Name: 
-- Module Name: CameraSensor - Behavioral
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

entity CameraSensor is
    Port ( SCL : in STD_LOGIC;
           SDATA : inout STD_LOGIC;
           VSYNC : out STD_LOGIC;
           HREF : out STD_LOGIC;
           PCLK : out STD_LOGIC;
           XCLK : in STD_LOGIC;
           DOUT9 : out STD_LOGIC;
           DOUT8 : out STD_LOGIC;
           DOUT7 : out STD_LOGIC;
           DOUT6 : out STD_LOGIC;
           DOUT5 : out STD_LOGIC;
           DOUT4 : out STD_LOGIC;
           DOUT3 : out STD_LOGIC;
           DOUT2 : out STD_LOGIC);
end CameraSensor;

architecture Behavioral of CameraSensor is

begin


end Behavioral;
