#!/usr/bin/expect

set pw xohk9ahrahkeesae4ZaeT7ingeechien

spawn git push
expect "git@46.149.18.17's password:"
send $pw\n

expect eof
