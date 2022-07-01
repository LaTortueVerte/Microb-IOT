#!/usr/bin/env python
# -*- coding: utf-8 -*-
from threading import Thread
from Module_Thread import module_Thread

# Receive list of module in database

# -------------------------------------------------- test zone
list_of_modules = [["Arduino", "/dev/ttyACM1"]]
# -------------------------------------------------- test zone

# Generate all threads

threads = []

for el in list_of_modules:

	print("create thread on port : ", el[1])
	
	new_module_thread = Thread(target = module_Thread, args = (el[0], el[1]))
	threads.append(new_module_thread)
	new_module_thread.start()

# Update local databases from AWS  

#while True:
	
	# -------------------------------------------------- test zone
	
	# -------------------------------------------------- test zone
