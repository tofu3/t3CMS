/*
 t3CMS:debug.js
 javascript functions for debugging t3CMS.
*/

 function d_toptoggle(t){
    p = document.getElementById('debug');
    s = document.getElementById('debugsub');

    if (s.style.display != 'block'){
        s.style.display = 'block';
        p.style.width = "100%";
        p.style.height = "33%";
        //p.style.top = "0px";
        p.style.background = '#eee';
        p.style.borderBottom = "1px black solid";
        p.style.opacity = '1';
    }
    else {
        s.style.display = 'none';
        p.style.width = "92px";
        p.style.height = "";
        //p.style.top = "-10px";
        p.style.background = 'transparent';
        p.style.borderBottom = "0px";
        p.style.opacity = '.5';
    }
 }

 function d_toggle(dn,l){
    d = document.getElementById('dvl'+dn);
    if (l.innerHTML[1] == '+'){
        d.style.display = 'block';
        l.innerHTML = '[-'+l.innerHTML.substr(2);
        l.style.marginBottom = '0px';
        l.style.MozBorderRadius = '5 5 0 0px';
    }
    else {
        d.style.display = 'none';
        l.innerHTML = '[+'+l.innerHTML.substr(2);
    }
 }
