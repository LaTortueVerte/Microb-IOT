#!/usr/bin/env python
# -*- coding: utf-8 -*-
# lsusb to check device name
#dmesg | grep "tty" to find port name

import serial, time

def module_Thread(thread_name, port):

        # Setup the serial communication
        
        with serial.Serial(port, 9600, timeout=1) as ser:
            time.sleep(0.1)
            if ser.isOpen():
                print("{} connected!".format(ser.port))      
                
                # Main loop 
                # planning : 
                #       1 - link databases ( receive cmds, update cmds (done) and update data (sensors) )
                #       2 - replace 'try-catch' and keyboard input by database conn
                #       3 - 
                      
                try:
                    while True:
                        
                        # Receive commands from database

                        # -------------------------------------------------- test zone
                        cmd = raw_input("cmd >> ")
                        # -------------------------------------------------- test zone
                        
                        # Send data to serial
                        
                        ser.write(cmd.encode())
                        time.sleep(0.1)
                        
                        # Receive data from serial
                    
                        start_time = time.time()
                        while (ser.inWaiting() == 0) and (time.time() - start_time < 5): 
                            pass
                            
                        if ser.inWaiting() > 0: 
                            answer = str(ser.readline())
                            dataList = answer.split("|")
                                
                            ser.flushInput()
                            
                            # Update commands (done) and data from sensors in database
                            
                            # -------------------------------------------------- test zone
                            print(dataList)
                            if len(dataList) == 16:
                                print("--------------")
                                print("GPL = ", dataList[0])
                                print("CH4 = ", dataList[1])
                                print("CO = ", dataList[2])
                                print("polluted = ", dataList[3])
                                print("readLevel = ", dataList[4])
                                print("formaldehydeDetect = ", dataList[5])
                                print("tempin = ", dataList[6])
                                print("humidity = ", dataList[7])
                                print("--------------")
                                print("2 = ", dataList[8])
                                print("3 = ", dataList[9])
                                print("4 = ", dataList[10])
                                print("5 = ", dataList[11])
                                print("6 = ", dataList[12])
                                print("7 = ", dataList[13])
                                print("8 = ", dataList[14])
                                print("9 = ", dataList[15])
                            else:
                                print("data error")
                            # -------------------------------------------------- test zone
                            
                        else:
                            
                            # Report Timeout in database
                            
                            print("Timeout")
                            
                except KeyboardInterrupt:
                    print("KeyboardInterrupt has been caught.")
                    
            else:
                print("not connected")  
                    

