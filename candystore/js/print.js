function writeMTable() {
 top.wRef=window.open('','myconsole',
  'width=500,height=450,left=10,top=10'
   +',menubar=1'
   +',toolbar=0'
   +',status=1'
   +',scrollbars=1'
   +',resizable=1')
 top.wRef.document.writeln(
  '<html><head><title>CandyStore Table</title></head>'
 +'<body bgcolor=whit</bodyad="self.focus()">'
 +'<center><font color=red><b><i>For printing, <a href=# onclick="window.print();return false;">click here</a> or press Ctrl+P</i></b></font>'
 +'<table border=0 cellspacing=3 cellpadding=3>'
 )

// top.wRef.document.writeln(buf+'</table></center></body></html>')
// top.wRef.document.close()
}
