__author__ = 'dwanyoike'

import mechanize
import cookielib
from BeautifulSoup import BeautifulSoup
import html2text
import json
import datetime
import dataset
import csv
import ssl

ssl._create_default_https_context = ssl._create_unverified_context
# Browser
br = mechanize.Browser()

# Cookie Jar
cj = cookielib.LWPCookieJar()
br.set_cookiejar(cj)

# Browser options
br.set_handle_equiv(True)
br.set_handle_gzip(True)
br.set_handle_redirect(True)
br.set_handle_referer(True)
br.set_handle_robots(False)
br.set_handle_refresh(mechanize._http.HTTPRefreshProcessor(), max_time=1)

br.addheaders = [('User-agent', 'Chrome')]

# The site we will navigate into, handling it's session
html = br.open('https://www.nse.co.ke/market-statistics/equity-statistics.html')
soup = BeautifulSoup(html.read())
table = soup.find('table')

db = dataset.connect('sqlite:///database/database.sqlite')
dbtable = db['stocks']

rows = table.findAll('tr')
for row in rows:
    cols = row.findAll('td')
    cols = [ele.text.strip() for ele in cols]
    # print cols
    if len(cols) == 4:
        cols = cols[:3 - 1]
        cols.append(datetime.datetime.now())
        dbtable.insert(dict(stock=cols[0], value=float(cols[1].replace(',','')), date=cols[2]))
        print(cols)

print(dbtable.all())
#myfile = open('stocks.csv', 'wb')
#wr = csv.writer(myfile, quoting=csv.QUOTE_ALL)

for user in dbtable.all():
    print(user)
    #wr.writerow(user.values())