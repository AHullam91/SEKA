function datumellenoriz(){
    var rendben = true;
    if(nap.value < 1 || nap.value > 31) rendben = false;
    if(ho.value < 1 || ho.value > 12) rendben = false;
    if(!rendben) alert('ilyen dátum nincs!');
    return rendben;
}

function datumIdoellenoriz(){
    var rendben = true;
    if(nap.value < 1 || nap.value > 31) rendben = false;
    if(ho.value < 1 || ho.value > 12) rendben = false;
    if(ora.value <1 || ora.value > 24) rendben = false;
    if(!rendben) alert('ilyen dátum nincs!');
    return rendben;
}