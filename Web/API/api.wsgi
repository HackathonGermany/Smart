import logging
import sys
logging.basicConfig(stream=sys.stderr)
sys.path.insert(0, '/home/beerma/python-api/')
from restserver import app as application
application.secret_key = 'gag43hr37hR§nuKWT§'