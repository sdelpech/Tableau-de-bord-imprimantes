import os
import time
import requests
from pysnmp.entity.rfc3413.oneliner import cmdgen # snmp requests

iod_serial = "1.3.6.1.4.1.2699.1.2.1.2.1.1.2.1"
iod_model = "1.3.6.1.2.1.25.3.2.1.3.1"
iod_name="1.3.6.1.2.1.1.5.0"
iod_total_page = "1.3.6.1.2.1.43.10.2.1.4.1.1"
#####HP######
iod_cnt_blk_hp = "	1.3.6.1.4.1.11.2.3.9.4.2.1.4.1.2.6.0"
iod_cnt_col_hp = "1.3.6.1.4.1.11.2.3.9.4.2.1.4.1.2.7.0"
iod_toner_black_hp = "1.3.6.1.2.1.43.11.1.1.9.1.1"
iod_toner_cyan_hp ="1.3.6.1.2.1.43.11.1.1.9.1.2"
iod_toner_yellow_hp ="1.3.6.1.2.1.43.11.1.1.9.1.3"
iod_toner_magenta_hp ="1.3.6.1.2.1.43.11.1.1.9.1.4"
#####LXMRK###
iod_cnt_blk_lxmrk = "1.3.6.1.4.1.641.6.4.2.2.1.6.1.1"
iod_cnt_col_lxmrk = "1.3.6.1.4.1.641.6.4.2.2.1.7.1.1"
iod_toner_black_lxmrk = "1.3.6.1.2.1.43.11.1.1.9.1.3"
iod_toner_cyan_lxmrk = "1.3.6.1.2.1.43.11.1.1.9.1.5"
iod_toner_yellow_lxmrk = "1.3.6.1.2.1.43.11.1.1.9.1.10"
iod_toner_magenta_lxmrk = "1.3.6.1.2.1.43.11.1.1.9.1.7"
iod_toner_max_lxmrk = 5000
#####COPIEURS###
iod_toner_black_koni = "1.3.6.1.2.1.43.11.1.1.9.1.1"
iod_toner_cyan_koni = "1.3.6.1.2.1.43.11.1.1.9.1.2"
iod_toner_magenta_koni = "1.3.6.1.2.1.43.11.1.1.9.1.3"
iod_toner_yellow_koni = "1.3.6.1.2.1.43.11.1.1.9.1.4"
iod_cnt_blk_koni = "	1.3.6.1.4.1.1129.2.3.50.1.3.21.6.1.2.1.3"
iod_cnt_col_koni = "1.3.6.1.4.1.1129.2.3.50.1.3.21.6.1.2.1.1"
#####XEROX#####
iod_model_xrx = "1.3.6.1.2.1.1.1.0"
iod_model_name_xrx ="1.3.6.1.2.1.1.5.0"
iod_cnt_blk_xrx = "1.3.6.1.4.1.253.8.53.13.2.1.6.1.20.34"
iod_cnt_col_xrx = "1.3.6.1.4.1.253.8.53.13.2.1.6.1.20.33"
iod_toner_black_xrx = "1.3.6.1.2.1.43.11.1.1.8.1.31"
iod_toner_cyan_xrx ="1.3.6.1.2.1.43.11.1.1.9.1.2"
iod_toner_yellow_xrx ="1.3.6.1.2.1.43.11.1.1.9.1.3"
iod_toner_magenta_xrx ="1.3.6.1.2.1.43.11.1.1.9.1.4"

def surcent(nb,total):
	nb = nb * 100 / int(total)
	return(nb)

def filtre(valeur):
	if(valeur == -2):
		valeur = "0"
	if(valeur == -3):
		valeur = "0"
	return(valeur)
	
def check_ping(IP):
	hostname = IP
	response = os.system("ping -c 1 " + hostname +" > /dev/null")
	# and then check the response...
	if response == 0:
		pingstatus = "Network Active"
	else:
		pingstatus = "Network Error"
	time.sleep(1)
	return pingstatus
	

def get_info(iod, IP):
	cmdGen = cmdgen.CommandGenerator()
	errorIndication, errorStatus, errorIndex, varBinds = cmdGen.getCmd(
		cmdgen.CommunityData('public', mpModel=0),
		cmdgen.UdpTransportTarget((IP, 161)),
		iod
		)
	
	if errorIndication:  # SNMP engine errors
		print(errorIndication)
	else:
		if errorStatus:  # SNMP agent errors
			print('%s at %s' % (errorStatus.prettyPrint(), varBinds[int(errorIndex)-1] if errorIndex else '?'))
		else:
			for varBind in varBinds:
				print(filtre(varBind[1]))
				return(filtre(varBind[1]))
				
def deja(ip,quoi):
	test = requests.post("https://URL/print/deja.php?ip=" + ip + "&quoi=" + quoi )
	return test.text
		
def printer_data(IP,BC,MARK):
	pingstatus = check_ping(IP)
	print(IP)
	if(pingstatus!="Network Error"):
		if(MARK == "HP"):
			printer_serial = " "
			printer_model = get_info(iod_model, IP)	
			printer_name = get_info(iod_name, IP)
			printer_counter = get_info(iod_total_page, IP)
			printer_counter_black = get_info(iod_total_page, IP)
			printer_toner_left_B = get_info(iod_toner_black_hp, IP)
			print(printer_toner_left_B)
			if(str(printer_model) == "HP LaserJet 4100 Series"):
				printer_toner_left_B = "%.2f" % surcent(printer_toner_left_B,4500)
			if(str(printer_model) == "HP LaserJet P3005"):
				if(printer_toner_left_B == None):
					printer_toner_left_B = 0
			if(str(printer_model) == "hp LaserJet 2420"):
				printer_toner_left_B = "%.2f" % surcent(printer_toner_left_B,12000)				
			if(BC == "C"):
				printer_counter_black = get_info(iod_cnt_blk_hp, IP)
				printer_counter_color = get_info(iod_cnt_col_hp, IP)
				printer_toner_left_C = get_info(iod_toner_cyan_hp, IP)
				printer_toner_left_Y = get_info(iod_toner_yellow_hp, IP)
				printer_toner_left_M = get_info(iod_toner_magenta_hp,IP)
					
		if(MARK  == "LXMRK"):
			printer_serial = get_info(iod_serial,IP)
			printer_model = get_info(iod_model, IP)	
			printer_name = get_info(iod_name, IP)
			printer_counter = get_info(iod_total_page, IP)
			printer_counter_black = get_info(iod_cnt_blk_lxmrk, IP)
			printer_counter_color = get_info(iod_cnt_col_lxmrk, IP)
			printer_toner_left_B = "%.2f" % surcent(get_info(iod_toner_black_lxmrk, IP),25000)
			printer_toner_left_C = "%.2f" % surcent(get_info(iod_toner_cyan_lxmrk, IP),5000)
			printer_toner_left_Y = "%.2f" % surcent(get_info(iod_toner_yellow_lxmrk, IP),5000)
			printer_toner_left_M = "%.2f" % surcent(get_info(iod_toner_magenta_lxmrk, IP),5000)
		if(MARK == "KONICA"):
			printer_serial = " "
			printer_model = get_info(iod_model_xrx, IP)	
			printer_name = get_info(iod_model_name_xrx, IP)
			printer_counter = get_info(iod_total_page, IP)
			printer_counter_black = get_info(iod_cnt_blk_koni, IP)
			printer_counter_color = get_info(iod_cnt_col_koni, IP)
			printer_toner_left_B = get_info(iod_toner_black_koni, IP)
			printer_toner_left_C = get_info(iod_toner_cyan_koni, IP)
			printer_toner_left_Y = get_info(iod_toner_yellow_koni, IP)
			printer_toner_left_M = get_info(iod_toner_magenta_koni, IP)
		if(MARK == "XEROX"):
			printer_serial = " "
			printer_model = get_info(iod_model_xrx, IP)	
			printer_name = get_info(iod_model_name_xrx, IP)
			printer_counter = get_info(iod_total_page, IP)
			printer_counter_black = get_info(iod_cnt_blk_xrx, IP)
			printer_counter_color = get_info(iod_cnt_col_xrx, IP)
			printer_toner_left_B = "%.2f" % surcent(get_info(iod_toner_black_xrx, IP),6500)  
			printer_toner_left_C = "%.2f" % surcent(get_info(iod_toner_cyan_xrx, IP),6500)
			printer_toner_left_Y = "%.2f" % surcent(get_info(iod_toner_yellow_xrx, IP),6500)
			printer_toner_left_M = "%.2f" % surcent(get_info(iod_toner_magenta_xrx, IP),6500)
			
			
		print(printer_toner_left_B)
		print(deja(IP,"IP"))
		if(deja(IP,"IP") == "FALSE"):
			if(BC == "C"):
				if(MARK == "HP"):
					print(IP + " : " + printer_model + "(" + printer_serial + ") : " + printer_name +" -> " + printer_counter + "pages("+ printer_counter_black + "  " + printer_counter_color + ") B:" + printer_toner_left_B +"% C:"+ printer_toner_left_C + "% M:" + printer_toner_left_M +"% Y:" + printer_toner_left_Y + "%")
					reponse = requests.post("https://URL/print/print.php",data={"tkn":"","ip":IP,"cpt_b":printer_counter_black,"cpt_c":printer_counter_color,"ton_b":printer_toner_left_B,"ton_c":printer_toner_left_C,"ton_y":printer_toner_left_Y,"ton_m":printer_toner_left_M})
					print(reponse.text)
				if(MARK =="LXMRK"):
					print(IP + " : " + printer_model + "(" + printer_serial + ") : " + printer_name +" -> " + printer_counter + "pages(" + printer_counter_black + " " + printer_counter_color + ") B:" + printer_toner_left_B +"% C:"+ printer_toner_left_C + "% M:" + printer_toner_left_M +"% Y:" + printer_toner_left_Y + "%")
					reponse = requests.post("https://URL/print/print.php",data={"tkn":"","ip":IP,"cpt_b":printer_counter_black,"cpt_c":printer_counter_color,"ton_b":printer_toner_left_B,"ton_c":printer_toner_left_C,"ton_y":printer_toner_left_Y,"ton_m":printer_toner_left_M})
					print(reponse.text)
				if(MARK=="KONICA"):
					reponse = requests.post("https://URL/print/print.php",data={"tkn":"","ip":IP,"cpt_b":printer_counter_black,"cpt_c":printer_counter_color,"ton_b":printer_toner_left_B,"ton_c":printer_toner_left_C,"ton_y":printer_toner_left_Y,"ton_m":printer_toner_left_M})
				if(MARK=="XEROX"):
						reponse = requests.post("https://URL/print/print.php",data={"tkn":"","ip":IP,"cpt_b":printer_counter_black,"cpt_c":printer_counter_color,"ton_b":printer_toner_left_B,"ton_c":printer_toner_left_C,"ton_y":printer_toner_left_Y,"ton_m":printer_toner_left_M})
		
			else:
				print(IP + " : " + printer_model + "(" + printer_serial + ") : " + printer_name +" -> " + printer_counter + "pages B:" + printer_toner_left_B + "%")
				reponse = requests.post("https://URL/print/print.php",data={"tkn":"","ip":IP,"cpt_b":printer_counter_black,"cpt_c":"NULL","ton_b":printer_toner_left_B,"ton_c":"NULL","ton_y":"NULL","ton_m":"NULL"})
				print(reponse.text)
				time.sleep(3)
printer_data("192.168.0.195","C","XEROX")			
printer_data("192.168.0.36","C","KONICA")
printer_data("192.168.0.117","C","KONICA")
printer_data("192.168.0.162","B","HP")
printer_data("192.168.0.188","B","HP")
printer_data("192.168.0.196","B","HP")
printer_data("192.168.0.212","B","HP")
printer_data("192.168.0.214","B","HP")
printer_data("192.168.0.222","B","HP")
printer_data("10.2.12.2","B","HP")
printer_data("192.168.0.4","B","HP")
printer_data("192.168.0.5","C","HP")#
printer_data("192.168.0.6","C","HP")#
printer_data("192.168.0.9","C","HP")
printer_data("192.168.0.27","B","HP")
printer_data("192.168.0.29","B","HP")
printer_data("192.168.0.60","B","HP")
printer_data("192.168.0.61","B","HP")
printer_data("192.168.0.62","B","HP")
printer_data("192.168.0.97","B","HP") #######BROTHER#####
printer_data("192.168.0.138","B","HP")
printer_data("192.168.0.151","B","HP")
printer_data("192.168.0.158","B","HP")
printer_data("192.168.0.159","B","HP")
printer_data("192.168.0.160","B","HP")
printer_data("192.168.0.161","B","HP")
printer_data("192.168.0.172","B","HP")
printer_data("192.168.0.175","B","HP")
printer_data("192.168.0.177","B","HP")
printer_data("192.168.0.183","B","HP")
printer_data("192.168.0.197","B","HP")
printer_data("192.168.0.200","C","HP")
printer_data("192.168.0.202","B","HP")
printer_data("192.168.0.203","B","HP")
printer_data("192.168.0.210","B","HP")
printer_data("192.168.0.221","C","HP")
printer_data("192.168.0.228","B","HP")
printer_data("192.168.0.233","B","HP")
printer_data("192.168.0.234","B","HP")
printer_data("192.168.0.242","B","HP")
printer_data("10.2.5.2","B","HP")
printer_data("10.2.6.2","B","HP")
printer_data("10.2.0.20","C","HP")
printer_data("10.2.7.2","B","HP")
printer_data("10.2.8.2","B","HP")
printer_data("10.2.9.2","B","HP")
printer_data("10.2.11.2","B","HP")
printer_data("10.2.13.2","B","HP")
printer_data("10.2.17.24","C","LXMRK")
printer_data("10.2.19.80","C","LXMRK")	

print(deja("","dlt"))
if(deja("", "dlt") == "FALSE"):
	reponse_daily = requests.post("https://URL/print/print_daily.php")
	print(reponse_daily.text)