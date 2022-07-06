set_property SRC_FILE_INFO {cfile:C:/Users/jules/Desktop/Travail/VHDL_Master_Camp/Nexys-Video-Master.xdc rfile:../../../../Nexys-Video-Master.xdc id:1} [current_design]
set_property src_info {type:XDC file:1 line:10 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN R4 IOSTANDARD LVCMOS33} [get_ports {clk}];
set_property src_info {type:XDC file:1 line:11 export:INPUT save:INPUT read:READ} [current_design]
create_clock -period 10.000 -name sys_clk_pin -waveform {0.000 5.000} -add [get_ports {clk}];
set_property src_info {type:XDC file:1 line:24 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN T14 IOSTANDARD LVCMOS25} [get_ports {TestLed}]; #LED0
set_property src_info {type:XDC file:1 line:25 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN T15 IOSTANDARD LVCMOS25} [get_ports {TestLedClk}];
set_property src_info {type:XDC file:1 line:26 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN T16 IOSTANDARD LVCMOS25} [get_ports {TOPAlgPIRes}];
set_property src_info {type:XDC file:1 line:27 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN U16 IOSTANDARD LVCMOS25} [get_ports {TOPAlgBuzzer_out}];
set_property src_info {type:XDC file:1 line:35 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN B22 IOSTANDARD LVCMOS12 } [get_ports { TestBtn }]; #IO_L20N_T3_16 Sch=btnc
set_property src_info {type:XDC file:1 line:36 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN D22 IOSTANDARD LVCMOS12 } [get_ports {TOPresetPir}]; #IO_L22N_T3_16 Sch=btnd
set_property src_info {type:XDC file:1 line:37 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN C22 IOSTANDARD LVCMOS12 } [get_ports { TOPPIRSensorState }]; #IO_L20P_T3_16 Sch=btnl
set_property src_info {type:XDC file:1 line:111 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN AB22 IOSTANDARD LVCMOS33} [get_ports {TOPAlgid_pin}];
set_property src_info {type:XDC file:1 line:112 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict {PACKAGE_PIN AB21 IOSTANDARD LVCMOS33} [get_ports {TOPAlgCode_pin}];
set_property src_info {type:XDC file:1 line:113 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN AB20  IOSTANDARD LVCMOS33 } [get_ports {  TOPAlgBuzzer_out}]; #IO_L15N_T2_DQS_DOUT_CSO_B_14 Sch=ja[3]
set_property src_info {type:XDC file:1 line:114 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN AB18  IOSTANDARD LVCMOS33 } [get_ports {  TOPPIRSensorState}]; #IO_L17N_T2_A13_D29_14 Sch=ja[4]
set_property src_info {type:XDC file:1 line:117 export:INPUT save:INPUT read:READ} [current_design]
set_property -dict { PACKAGE_PIN AA20  IOSTANDARD LVCMOS33 } [get_ports { TOPAlgTX_pin }]; #IO_L8P_T1_D11_14 Sch=ja[9]
set_property src_info {type:XDC file:1 line:315 export:INPUT save:INPUT read:READ} [current_design]
set_property BEL DFF [get_cells {U4/id_o_reg[3]}];
set_property src_info {type:XDC file:1 line:316 export:INPUT save:INPUT read:READ} [current_design]
set_property LOC SLICE_X0Y70 [get_cells {U4/id_o_reg[3]}];
set_property src_info {type:XDC file:1 line:317 export:INPUT save:INPUT read:READ} [current_design]
set_property BEL CFF [get_cells {U4/id_o_reg[0]}];
set_property src_info {type:XDC file:1 line:318 export:INPUT save:INPUT read:READ} [current_design]
set_property LOC SLICE_X0Y70 [get_cells {U4/id_o_reg[0]}];
