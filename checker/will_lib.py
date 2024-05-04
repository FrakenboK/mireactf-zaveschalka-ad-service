from typing import Optional

import checklib
from checklib import BaseChecker
import requests
from bs4 import BeautifulSoup

PORT = 1782

class WillLib:
    @property
    def api_url(self):
        return f'http://{self.host}:{self.port}/'

    def __init__(self, checker: BaseChecker, port=PORT, host=None):
        self.c = checker
        self.port = port
        self.host = host or self.c.host

    def ping(self):
        try:
            requests.get(f'{self.api_url}')
            return 1
        except Exception as e:
            return 0

    def register(self, session: requests.Session, username, password, email: str, phone: int) -> str:
        resp = session.post(f'{self.api_url}/register.php', data={
            'login': username,
            'password': password,
            'phone': phone,
            'email': email 
        })
        self.c.assert_eq(resp.status_code, 200, 'Failed to register')
        resp_data = self.c.get_text(resp, 'Failed to signup: invalid data')
        return resp_data

    def login(self, session: requests.Session, username: str, password: str):
        resp = session.post(f'{self.api_url}/login.php', data={
            'login': username,
            'password': password
        })
        self.c.assert_eq(resp.status_code, 200, 'Failed to signin')
        resp_data = self.c.get_text(resp, 'Failed to signin: invalid data')
        return resp_data
    
    def writeNote(self, session: requests.Session, username: str, password: str, note):
        resp = session.post(f'{self.api_url}/notes', data={'note': note})
        self.c.assert_eq(resp.status_code, 200, 'Failed to write note')

        soup = BeautifulSoup(resp.text, "html.parser")
        req = soup.find("h3", class_="id")
        
        return req.text
    
    def checkNote(self, session: requests.Session, username: str, password: str, id, flag: str):
        resp = session.get(f'{self.api_url}/notes?id={id}')
        if flag in resp.text:
            return 1
        return 0