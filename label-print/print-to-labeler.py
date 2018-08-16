import socket
from brotherprint import BrotherPrint
import sys

if len(sys.argv) < 4:
    sys.exit('usage: print-to-labeler.py "printerip" "heading" "visitorname" "reason"')

printerip = sys.argv[1]
heading = sys.argv[2]
visitorname = sys.argv[3]
reason = sys.argv[4]

# sys.exit("done")

f_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
f_socket.connect((printerip,9100))
printjob = BrotherPrint(f_socket)

printjob.template_mode()
printjob.template_init()
printjob.choose_template(1)
printjob.select_and_insert("heading", heading)
printjob.select_and_insert("visitorname", visitorname)
printjob.select_and_insert("reason", reason)
printjob.template_print()