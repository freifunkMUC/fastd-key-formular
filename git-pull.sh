#!/usr/bin/expect

source password.sh

spawn git pull
expect "git@46.149.18.17's password:"
send $pw\n

expect eof
