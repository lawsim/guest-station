from PIL import Image, ImageDraw, ImageFont
import socket
import sys
from time import gmtime, strftime, localtime
import subprocess, os
import textwrap

if len(sys.argv) < 4:
    sys.exit('usage: generate_label.py "printerip" "heading" "firstname" "lastname" "reason"')

printerip = sys.argv[1]
heading = sys.argv[2]
fname = sys.argv[3]
lname = sys.argv[4]
reason = sys.argv[5]

script_dir = os.path.dirname(os.path.realpath(__file__)) + "\\"
# print(script_dir)
# sys.exit(0)

# img = Image.new('RGB', (696,250), color='red')
max_w = 696
max_h = 560
spacer_gap = 5
name_font_size = 115
text_font_size = 45
img = Image.new('RGB', (max_w,max_h), color='white')
draw = ImageDraw.Draw(img)

# draw top red
top_h = 100
draw.rectangle([(0,0),(max_w,top_h)], fill='red')

# write visitor
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Bold.ttf', 70)
text = heading
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, (top_h/2 - h/2)), text, fill='white', font=fnt)

# draw top red
spacer_start_h = top_h + spacer_gap
spacer_h = spacer_gap
draw.rectangle([(0,spacer_start_h),(max_w,spacer_start_h+spacer_h)], fill='red')

# text area
text_h_start = spacer_start_h + spacer_h + spacer_gap*4

# draw name
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Bold.ttf', name_font_size)
h_pos = text_h_start
# lines = visitorname.split()
# i = 0
# h = 0
# for name in lines:
	# text = (name[:9] + '..') if len(name) > 9 else name
	# w3, h3 = draw.textsize(text, font=fnt)
	# draw.text(((max_w - w3) / 2, h_pos), text, fill='black', font=fnt)
	# h_pos += h3 + 2
	
	# h += h3
	# i += 1
	# if i > 1:
		# break
	
text = (fname[:10] + '..') if len(fname) > 10 else fname
text = text.lower().title()
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, h_pos), text, fill='black', font=fnt)

h_pos = h_pos + h + spacer_gap
text = (lname[:10] + '..') if len(lname) > 10 else lname
text = text.lower().title()
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, h_pos), text, fill='black', font=fnt)

#draw reason
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Regular.ttf', text_font_size)
h_pos = h_pos+h+spacer_gap

text = (reason[:30] + '...') if len(reason) > 30 else reason

text = "%s%s" % (text[0].upper(), text[1:].lower())


w3, h3 = draw.textsize(text, font=fnt)
draw.text(((max_w - w3) / 2, h_pos), text, fill='black', font=fnt)
    
# lines = textwrap.wrap(reason, width=30)
# for text in lines:
	# w3, h3 = draw.textsize(text, font=fnt)
	# draw.text(((max_w - w3) / 2, h_pos), text, fill='black', font=fnt)
	# h_pos += h3 + 2

# draw bottom bar
bottom_bar_h_start = max_h-70
bottom_bar_h = max_h
draw.rectangle([(0,bottom_bar_h_start),(max_w,bottom_bar_h)], fill='red')

# draw date/time
fnt = ImageFont.truetype(script_dir + 'fonts/Roboto-Regular.ttf', text_font_size)
text = strftime("%b %d, %Y %I:%M %p", localtime()).replace(" 0", " ")
w, h = draw.textsize(text, font=fnt)
draw.text(((max_w - w) / 2, (bottom_bar_h_start+(70/2) - h/2)), text, fill='white', font=fnt)



img.save(script_dir + 'label.png')

my_env = os.environ.copy()
my_env["BROTHER_QL_PRINTER"] = "tcp://"+printerip
my_env["BROTHER_QL_MODEL"] = "QL-810W"

subprocess.Popen("brother_ql print -l 62 --red " + script_dir + "label.png", env=my_env)