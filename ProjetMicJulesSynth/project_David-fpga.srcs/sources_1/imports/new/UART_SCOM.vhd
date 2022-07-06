library ieee;
use ieee.std_logic_1164.ALL;
use ieee.numeric_std.all;

library work;
use work.all;

entity UART_SCOM is
port(CLOCK : in std_logic;
     TX_pin : out std_logic; -- voir fonctionnement dans uart tx 
     RX_pin : in std_logic;
	 SW_pins :in std_logic_vector(7 downto 0); -- byte gen
	 id_pins : out std_logic_vector(3 downto 0); -- code map 
	 code_pins : out std_logic_vector(3 downto 0) -- code map 
	 );
end entity UART_SCOM;

architecture struct of UART_SCOM is

        
	component freq_div is
	port(   
		clkin:in std_logic; -- 100 MHz -> 10ns
		clkout:out std_logic 
		);
	end component freq_div;

	component UART_TX is
	  generic (
		g_CLKS_PER_BIT : integer := 1302
		);
	  port (
		i_Clk       : in  std_logic;
		i_TX_DV     : in  std_logic;
		i_TX_Byte   : in  std_logic_vector(7 downto 0);
		o_TX_Active : out std_logic;
		o_TX_Serial : out std_logic;
		o_TX_Done   : out std_logic
		);
	end component UART_TX;

	component UART_RX is
	  generic (
		g_CLKS_PER_BIT : integer := 1302
		);
	  port (
		i_Clk       : in  std_logic;
		i_RX_Serial : in  std_logic;
		o_RX_DV     : out std_logic;
		o_RX_Byte   : out std_logic_vector(7 downto 0)
		);
	end component UART_RX;

	component byte_gen is
	port(
		  en : out std_logic;
		  id_i : in std_logic_vector(3 downto 0);
		  code_i : in std_logic_vector(3 downto 0);
		  byte_o : out std_logic_vector(7 downto 0)
		  );
	end component byte_gen;

	component id_code_gen is
	port(
		done:in std_logic;
		byte_i: in std_logic_vector(7 downto 0);
		id_o: out std_logic_vector(3 downto 0);
		code_o: out std_logic_vector(3 downto 0)
	);
	end component id_code_gen;

	signal Tx_B, Rx_B : std_logic_vector(7 downto 0);
	signal en_Tx, DV_Rx, clk_int : std_logic;

begin

	U0: freq_div port map (clkin => CLOCK, clkout => clk_int);

	U1: byte_gen port map (en => en_Tx,
						   id_i => SW_pins(7 downto 4),
						   code_i => SW_pins(3 downto 0),
						   byte_o => Tx_B
						   );

	U2: UART_TX generic map (g_CLKS_PER_BIT=> 1302) 
			port map(i_Clk => clk_int, 
						i_TX_DV => en_Tx, 
						i_TX_Byte => Tx_B, 
						o_TX_Serial => TX_pin, 
						o_TX_Active => open,
						o_TX_Done=> open
						);

	U3: UART_RX generic map (g_CLKS_PER_BIT=> 1302)  
			  port map (i_Clk => clk_int,
						i_RX_Serial => RX_pin,
						o_RX_DV => DV_Rx,
						o_RX_Byte => Rx_B
						);

	U4: id_code_gen port map (done => DV_Rx,
								byte_i => Rx_B,
								id_o => id_pins,
								code_o => code_pins
								);
	

end architecture struct;

