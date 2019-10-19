from flask import Flask, json, jsonify, abort, request
from flask_httpauth import HTTPBasicAuth
import os

api = Flask(__name__)


@api.route('/', methods=['GET'])
def welcome():
    response = jsonify({'message':'Welcome to the dying-earth API', 'version': '1.0'})
    return response, 401


if __name__ == '__main__':
    api.run()
