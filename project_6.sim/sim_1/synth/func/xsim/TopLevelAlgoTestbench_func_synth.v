// Copyright 1986-2018 Xilinx, Inc. All Rights Reserved.
// --------------------------------------------------------------------------------
// Tool Version: Vivado v.2018.3 (win64) Build 2405991 Thu Dec  6 23:38:27 MST 2018
// Date        : Wed Jul  6 21:42:12 2022
// Host        : LAPTOP-UHBHC1L8 running 64-bit major release  (build 9200)
// Command     : write_verilog -mode funcsim -nolib -force -file
//               C:/Users/recho/OneDrive/Bureau/EFREI/MasterCamp/project_6/project_6.sim/sim_1/synth/func/xsim/TopLevelAlgoTestbench_func_synth.v
// Design      : TopLevelControlAlgo
// Purpose     : This verilog netlist is a functional simulation representation of the design and should not be modified
//               or synthesized. This netlist cannot be used for SDF annotated simulation.
// Device      : xc7k70tfbv676-1
// --------------------------------------------------------------------------------
`timescale 1 ps / 1 ps

module TestLedCpnt
   (TestLedClk,
    CLK);
  output TestLedClk;
  input CLK;

  wire CLK;
  wire TestLedClk;
  wire clear;
  wire [5:0]count_reg__0;
  wire [5:0]plusOp__0;

  FDRE #(
    .INIT(1'b0)) 
    TestLedClk_reg
       (.C(CLK),
        .CE(1'b1),
        .D(clear),
        .Q(TestLedClk),
        .R(1'b0));
  LUT1 #(
    .INIT(2'h1)) 
    \count[0]_i_1__0 
       (.I0(count_reg__0[0]),
        .O(plusOp__0[0]));
  (* SOFT_HLUTNM = "soft_lutpair1" *) 
  LUT2 #(
    .INIT(4'h6)) 
    \count[1]_i_1__0 
       (.I0(count_reg__0[0]),
        .I1(count_reg__0[1]),
        .O(plusOp__0[1]));
  (* SOFT_HLUTNM = "soft_lutpair1" *) 
  LUT3 #(
    .INIT(8'h78)) 
    \count[2]_i_1__0 
       (.I0(count_reg__0[0]),
        .I1(count_reg__0[1]),
        .I2(count_reg__0[2]),
        .O(plusOp__0[2]));
  (* SOFT_HLUTNM = "soft_lutpair0" *) 
  LUT4 #(
    .INIT(16'h7F80)) 
    \count[3]_i_1__0 
       (.I0(count_reg__0[1]),
        .I1(count_reg__0[0]),
        .I2(count_reg__0[2]),
        .I3(count_reg__0[3]),
        .O(plusOp__0[3]));
  (* SOFT_HLUTNM = "soft_lutpair0" *) 
  LUT5 #(
    .INIT(32'h7FFF8000)) 
    \count[4]_i_1 
       (.I0(count_reg__0[2]),
        .I1(count_reg__0[0]),
        .I2(count_reg__0[1]),
        .I3(count_reg__0[3]),
        .I4(count_reg__0[4]),
        .O(plusOp__0[4]));
  LUT6 #(
    .INIT(64'h7FFFFFFF80000000)) 
    \count[5]_i_1 
       (.I0(count_reg__0[3]),
        .I1(count_reg__0[1]),
        .I2(count_reg__0[0]),
        .I3(count_reg__0[2]),
        .I4(count_reg__0[4]),
        .I5(count_reg__0[5]),
        .O(plusOp__0[5]));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[0] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[0]),
        .Q(count_reg__0[0]),
        .R(clear));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[1] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[1]),
        .Q(count_reg__0[1]),
        .R(clear));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[2] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[2]),
        .Q(count_reg__0[2]),
        .R(clear));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[3] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[3]),
        .Q(count_reg__0[3]),
        .R(clear));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[4] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[4]),
        .Q(count_reg__0[4]),
        .R(clear));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[5] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp__0[5]),
        .Q(count_reg__0[5]),
        .R(clear));
  LUT6 #(
    .INIT(64'h4000000000000000)) 
    eqOp
       (.I0(count_reg__0[0]),
        .I1(count_reg__0[5]),
        .I2(count_reg__0[4]),
        .I3(count_reg__0[3]),
        .I4(count_reg__0[1]),
        .I5(count_reg__0[2]),
        .O(clear));
endmodule

(* NotValidForBitStream *)
module TopLevelControlAlgo
   (CLOCK,
    TOPPIRSensorState,
    TOPresetPir,
    TOPAlgPIRes,
    TOPAlgBuzzer_out,
    TOPAlgRX_pin,
    TOPAlgTX_pin,
    TestBtn,
    TestLed,
    TestLedClk);
  input CLOCK;
  input TOPPIRSensorState;
  input TOPresetPir;
  output TOPAlgPIRes;
  output TOPAlgBuzzer_out;
  input TOPAlgRX_pin;
  output TOPAlgTX_pin;
  input TestBtn;
  output TestLed;
  output TestLedClk;

  wire CLOCK;
  wire CLOCK_IBUF;
  wire CLOCK_IBUF_BUFG;
  wire TOPAlgBuzzer_out;
  wire TOPAlgPIRes;
  wire TOPAlgTX_pin;
  wire TOPAlgTX_pin_OBUF;
  wire TestBtn;
  wire TestLed;
  wire TestLedClk;
  wire TestLedClk_OBUF;
  wire TestLed_OBUF;

  BUFG CLOCK_IBUF_BUFG_inst
       (.I(CLOCK_IBUF),
        .O(CLOCK_IBUF_BUFG));
  IBUF CLOCK_IBUF_inst
       (.I(CLOCK),
        .O(CLOCK_IBUF));
  TestLedCpnt CptLed
       (.CLK(CLOCK_IBUF_BUFG),
        .TestLedClk(TestLedClk_OBUF));
  OBUF TOPAlgBuzzer_out_OBUF_inst
       (.I(1'b0),
        .O(TOPAlgBuzzer_out));
  OBUF TOPAlgPIRes_OBUF_inst
       (.I(1'b0),
        .O(TOPAlgPIRes));
  OBUF TOPAlgTX_pin_OBUF_inst
       (.I(TOPAlgTX_pin_OBUF),
        .O(TOPAlgTX_pin));
  IBUF TestBtn_IBUF_inst
       (.I(TestBtn),
        .O(TestLed_OBUF));
  OBUF TestLedClk_OBUF_inst
       (.I(TestLedClk_OBUF),
        .O(TestLedClk));
  OBUF TestLed_OBUF_inst
       (.I(TestLed_OBUF),
        .O(TestLed));
  UART_SCOM UART_Raspi
       (.CLK(CLOCK_IBUF_BUFG),
        .TOPAlgTX_pin_OBUF(TOPAlgTX_pin_OBUF));
endmodule

module UART_SCOM
   (TOPAlgTX_pin_OBUF,
    CLK);
  output TOPAlgTX_pin_OBUF;
  input CLK;

  wire CLK;
  wire TOPAlgTX_pin_OBUF;
  wire clk_int;

  freq_div U0
       (.CLK(CLK),
        .Q(clk_int));
  UART_TX U2
       (.TOPAlgTX_pin_OBUF(TOPAlgTX_pin_OBUF),
        .in0(clk_int));
endmodule

module UART_TX
   (TOPAlgTX_pin_OBUF,
    in0);
  output TOPAlgTX_pin_OBUF;
  input in0;

  wire FSM_sequential_r_SM_Main_reg_n_0;
  wire TOPAlgTX_pin_OBUF;
  wire in0;
  wire o_TX_Serial_i_1_n_0;

  (* FSM_ENCODED_STATES = "s_tx_data_bits:010,s_tx_stop_bit:011,s_cleanup:100,s_idle:0,s_tx_start_bit:1" *) 
  FDRE #(
    .INIT(1'b0)) 
    FSM_sequential_r_SM_Main_reg
       (.C(in0),
        .CE(1'b1),
        .D(1'b1),
        .Q(FSM_sequential_r_SM_Main_reg_n_0),
        .R(1'b0));
  LUT1 #(
    .INIT(2'h1)) 
    o_TX_Serial_i_1
       (.I0(FSM_sequential_r_SM_Main_reg_n_0),
        .O(o_TX_Serial_i_1_n_0));
  FDRE #(
    .INIT(1'b0)) 
    o_TX_Serial_reg
       (.C(in0),
        .CE(1'b1),
        .D(o_TX_Serial_i_1_n_0),
        .Q(TOPAlgTX_pin_OBUF),
        .R(1'b0));
endmodule

module freq_div
   (Q,
    CLK);
  output [0:0]Q;
  input CLK;

  wire CLK;
  wire [0:0]Q;
  wire \count_reg_n_0_[0] ;
  wire \count_reg_n_0_[1] ;
  wire \count_reg_n_0_[2] ;
  wire [3:0]plusOp;

  (* SOFT_HLUTNM = "soft_lutpair3" *) 
  LUT1 #(
    .INIT(2'h1)) 
    \count[0]_i_1 
       (.I0(\count_reg_n_0_[0] ),
        .O(plusOp[0]));
  (* SOFT_HLUTNM = "soft_lutpair3" *) 
  LUT2 #(
    .INIT(4'h6)) 
    \count[1]_i_1 
       (.I0(\count_reg_n_0_[0] ),
        .I1(\count_reg_n_0_[1] ),
        .O(plusOp[1]));
  (* SOFT_HLUTNM = "soft_lutpair2" *) 
  LUT3 #(
    .INIT(8'h78)) 
    \count[2]_i_1 
       (.I0(\count_reg_n_0_[0] ),
        .I1(\count_reg_n_0_[1] ),
        .I2(\count_reg_n_0_[2] ),
        .O(plusOp[2]));
  (* SOFT_HLUTNM = "soft_lutpair2" *) 
  LUT4 #(
    .INIT(16'h7F80)) 
    \count[3]_i_1 
       (.I0(\count_reg_n_0_[1] ),
        .I1(\count_reg_n_0_[0] ),
        .I2(\count_reg_n_0_[2] ),
        .I3(Q),
        .O(plusOp[3]));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[0] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp[0]),
        .Q(\count_reg_n_0_[0] ),
        .R(1'b0));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[1] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp[1]),
        .Q(\count_reg_n_0_[1] ),
        .R(1'b0));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[2] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp[2]),
        .Q(\count_reg_n_0_[2] ),
        .R(1'b0));
  FDRE #(
    .INIT(1'b0)) 
    \count_reg[3] 
       (.C(CLK),
        .CE(1'b1),
        .D(plusOp[3]),
        .Q(Q),
        .R(1'b0));
endmodule
`ifndef GLBL
`define GLBL
`timescale  1 ps / 1 ps

module glbl ();

    parameter ROC_WIDTH = 100000;
    parameter TOC_WIDTH = 0;

//--------   STARTUP Globals --------------
    wire GSR;
    wire GTS;
    wire GWE;
    wire PRLD;
    tri1 p_up_tmp;
    tri (weak1, strong0) PLL_LOCKG = p_up_tmp;

    wire PROGB_GLBL;
    wire CCLKO_GLBL;
    wire FCSBO_GLBL;
    wire [3:0] DO_GLBL;
    wire [3:0] DI_GLBL;
   
    reg GSR_int;
    reg GTS_int;
    reg PRLD_int;

//--------   JTAG Globals --------------
    wire JTAG_TDO_GLBL;
    wire JTAG_TCK_GLBL;
    wire JTAG_TDI_GLBL;
    wire JTAG_TMS_GLBL;
    wire JTAG_TRST_GLBL;

    reg JTAG_CAPTURE_GLBL;
    reg JTAG_RESET_GLBL;
    reg JTAG_SHIFT_GLBL;
    reg JTAG_UPDATE_GLBL;
    reg JTAG_RUNTEST_GLBL;

    reg JTAG_SEL1_GLBL = 0;
    reg JTAG_SEL2_GLBL = 0 ;
    reg JTAG_SEL3_GLBL = 0;
    reg JTAG_SEL4_GLBL = 0;

    reg JTAG_USER_TDO1_GLBL = 1'bz;
    reg JTAG_USER_TDO2_GLBL = 1'bz;
    reg JTAG_USER_TDO3_GLBL = 1'bz;
    reg JTAG_USER_TDO4_GLBL = 1'bz;

    assign (strong1, weak0) GSR = GSR_int;
    assign (strong1, weak0) GTS = GTS_int;
    assign (weak1, weak0) PRLD = PRLD_int;

    initial begin
	GSR_int = 1'b1;
	PRLD_int = 1'b1;
	#(ROC_WIDTH)
	GSR_int = 1'b0;
	PRLD_int = 1'b0;
    end

    initial begin
	GTS_int = 1'b1;
	#(TOC_WIDTH)
	GTS_int = 1'b0;
    end

endmodule
`endif
