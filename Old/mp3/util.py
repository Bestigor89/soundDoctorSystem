#!/usr/bin/env python
# -*- coding: utf-8 -*-

import argparse
import sys
import os

directory = ['01','04','05','06','07','08','09','10','11','12','13','14','15','16']

reload(sys)
sys.setdefaultencoding('utf8')

for d in directory :
#Получаем список файлов в переменную files
  files = os.listdir("./"+d)

#Фильтруем список
  mp3 = filter(lambda x: x.endswith('.mp3'), files) 

  for s in mp3 :
    print """insert into doctor.`doc_track`(`part_id`,`track_name`,`track_url`,`duration`) select %(p)d, '%(a)s', 'mp3/%(e)s/%(b)s', 60;""" % {"a":unicode(s, "utf-8"), "b":unicode(s, "utf-8"),"e":d,"p":int(d)}
