#!/usr/bin/python3

#Gather system information and print each result line-by-line to the console

from uptime import uptime
from os import getloadavg
import psutil

def getUptimeString():
  uptimeseconds = uptime()
  days = int(((uptimeseconds/60)/60)//24)
  uptimeseconds -= days*24*60*60
  hours = int((uptimeseconds/60)//60)
  uptimeseconds -= hours*60*60
  minutes = int(uptimeseconds//60)
  uptimeseconds -= minutes*60
  seconds = int(uptimeseconds)
  string = ""
  if days > 0:
    string+=str(days)
    if days == 1:
      string+=" day, "
    else:
      string+=" days, "
  if hours > 0:
    string+=str(hours)
    if hours == 1:
      string+=" hour, "
    else:
      string+=" hours, "
  if minutes > 0:
    string+=str(minutes)
    if minutes == 1:
      string+=" minute, "
    else:
      string+=" minutes, "
  string+=str(seconds)
  if seconds == 1:
    string+=" second."
  else:
    string+=" seconds."
  return string

def getLoadAverageString():
  t = getloadavg()
  string = ""
  string+="One minute load: %.2f" % t[0]
  string+=", %.2f five minutes, %.2f fifteen minute load." % (t[1],t[2])
  return string

def checkProcs():
  apache = False
  ntpd = False
  fail2ban = False
  sshd = False
  for proc in psutil.process_iter():
    try:
      pname = proc.name()
      if "ntpd" in pname:
        ntpd = True
      elif "apache" in pname:
        apache = True
      elif "fail2ban" in pname:
        fail2ban = True
      elif "sshd" in pname:
        sshd = True
    except psutil.NoSuchProcess:
      pass
  string=""
  if apache:
    string+="Apache is running.\n"
  else:
    string+="Apache is NOT running!\n"
  if fail2ban:
    string+="Fail2ban is running.\n"
  else:
    string+="Fail2ban is NOT running!\n"
  if ntpd:
    string+="NTPD is running.\n"
  else:
    string+="NTPD is NOT running!\n"
  if sshd:
    string+="SSHD is running.\n"
  else:
    string+="SSHD is NOT running!\n"
  if apache and fail2ban and ntpd and sshd:
    string+="\nEverything seems to be running normally.\n"
  return string

def getMemoryInfoString():
  b2m = 1024*1024
  t = psutil.virtual_memory()
  bf = t.buffers+t.cached
  string=""
  string+="Total Memory: %d" % (t.total/b2m) + "MB"
  string+="\nAvailable: %d" % (t.available/b2m) + "MB"
  string+="\nUsed Memory: %d" % ((t.used-bf)/b2m) + "MB"
  string+="\nPercent Used: %.2f" % (((t.used-bf)/t.available)*100) + "%"
  string+="\nFree Memory: %d" % ((t.free+bf)/b2m) + "MB"
  return string

def main():
  print("System up and running for "+getUptimeString())
  print(getLoadAverageString())
  print("\nMemory Information:\n")
  print(getMemoryInfoString())
  print("\nServices:\n")
  print(checkProcs())

if __name__=='__main__':
  main()


