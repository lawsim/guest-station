from PIL import Image, ImageDraw, ImageFont
import socket
import sys
from time import gmtime, strftime, localtime
import subprocess, os
import textwrap

if len(sys.argv) < 4:
    sys.exit('usage: generate_label.py "printerip" "heading" "visitorname" "reason"')

printerip = sys.argv[1]
heading = sys.argv[2]
visitorname = sys.argv[3]
reason = sys.argv[4]

script_dir = os.path.dirname(os.path.realpath(__file__)) + "\\"
# print(script_dir)
# sys.exit(0)

# img = Image.new('RGB', (696,250), color='red')
max_w = 696
max_h = 400
spacer_gap = 5
name_font_size = 55
text_font_size = 45
img = Image.new('RGB', (max_w,max_h), color='white')
draw = ImageDraw.Draw(img)

# draw top red
top_h = 100
draw.rectangle([(0,0),(max_w,top_h)], fill='red')

# write visitor
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Bold.ttf', 80)
text = heading
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, (top_h/2 - h/2)), text, fill='white', font=fnt)

# draw top red
spacer_start_h = top_h + spacer_gap
spacer_h = spacer_gap
draw.rectangle([(0,spacer_start_h),(max_w,spacer_start_h+spacer_h)], fill='red')

# text area
text_h_start = spacer_start_h + spacer_h + spacer_gap*2
text_w_start = 20

# draw name
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Bold.ttf', name_font_size)
text = visitorname
w, h = draw.textsize(text, font=fnt)
h_pos = text_h_start
draw.text((text_w_start, h_pos), text, fill='black', font=fnt)

#draw reason
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Regular.ttf', text_font_size)
lines = textwrap.wrap(reason, width=40)
h_pos = text_h_start+h+spacer_gap

for text in lines:
	w3, h3 = draw.textsize(text, font=fnt)
	draw.text((text_w_start, h_pos), text, fill='black', font=fnt)
	h_pos += h3 + 2

# draw bottom bar
bottom_bar_h_start = max_h-70
bottom_bar_h = max_h
draw.rectangle([(0,bottom_bar_h_start),(max_w,bottom_bar_h)], fill='red')

# draw date/time
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Regular.ttf', text_font_size)
text = strftime("%b %d, %Y %I:%M %p", localtime())
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, (bottom_bar_h_start+(70/2) - h/2)), text, fill='white', font=fnt)



img.save(script_dir + 'label.png')

my_env = os.environ.copy()
my_env["BROTHER_QL_PRINTER"] = "tcp://"+printerip
my_env["BROTHER_QL_MODEL"] = "QL-810W"

# subprocess.Popen("brother_ql print -l 62 --red " + script_dir + "label.png", env=my_env)