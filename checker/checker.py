#!/usr/bin/env python3
import random
import sys

import requests
from checklib import *
from checklib import status

import will_lib

class Checker(BaseChecker):
    vulns: int = 1
    timeout: int = 15
    uses_attack_data: bool = True

    req_ua_agents = ['python-requests/2.{}.0'.format(x) for x in range(15, 28)]
    req_ua_agents += ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.6367.118 Safari/537.{}'.format(x) for x in range(30, 40)]
    req_ua_agents += ['MEREACTF', 'HELLO_FROM_MIREA', 'BEBEBEBBEBE', 'BEBRA', 'ROBERT SAMA']

    def __init__(self, *args, **kwargs):
        super(Checker, self).__init__(*args, **kwargs)
        self.lib = will_lib.WillLib(self)

    def session_with_req_ua(self):
        sess = get_initialized_session()
        if random.randint(0, 10) != 1:
            sess.headers['User-Agent'] = random.choice(self.req_ua_agents)
            
        #sess.headers['Content-Type'] = 'application/x-www-form-urlencoded'
        return sess

    def check(self):
        session = self.session_with_req_ua()
        username1, password1, email1 = rnd_username(), rnd_password(), f'{rnd_string(10)}@{rnd_string(5)}.{rnd_string(3)}' 
        phone1 = random.randint(1000000, 10000000)

        username2, password2, email2 = rnd_username(), rnd_password(), f'{rnd_string(10)}@{rnd_string(5)}.{rnd_string(3)}' 
        phone2 = random.randint(1000000, 10000000)
        
        ping = self.lib.ping()
        if not ping:
            self.cquit(Status.DOWN)
        
        self.lib.register(session, username1, password1, email1, phone1)
        #self.lib.signin(session, username, password)

        self.cquit(Status.OK)

    def put(self, flag_id: str, flag: str, vuln: str):
        sess = self.session_with_req_ua()
        u = rnd_username()
        p = rnd_password()

        self.lib.register(sess, u, p)
        self.lib.login(sess, u, p)

        note = flag
        id = self.lib.writeNote(sess, u, p, note)

        if id:
            self.cquit(Status.OK, u, f"{u}:{p}:{id}")

        self.cquit(Status.MUMBLE)

    def get(self, flag_id: str, flag: str, vuln: str):
        u, p, id = flag_id.split(':')
        sess = self.session_with_req_ua()
        self.lib.signin(sess, u, p, status=Status.CORRUPT)

        check = self.lib.checkNote(sess, u, p, id, flag)
        if not check:
            self.cquit(Status.CORRUPT)

        self.cquit(Status.OK)

if __name__ == '__main__':
    c = Checker(sys.argv[2])
    try:
        c.action(sys.argv[1], *sys.argv[3:])
    except c.get_check_finished_exception() as e:
        cquit(status.Status(c.status), c.public, c.private)