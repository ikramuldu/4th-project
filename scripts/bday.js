var bDaySelect=document.getElementsByName("birthday_day")[0];
var bMonthSelect=document.getElementsByName("birthday_month")[0];
var bYearSelect=document.getElementsByName("birthday_year")[0];
var i;

for(i=2017;i>=1930;i--){
    bYearSelect.innerHTML+='<option value="'+i+'">'+i+'</option>';
}

for(i=1;i<=31;i++){
    bDaySelect.innerHTML+='<option value="'+i+'">'+i+'</option>';
}

bYearSelect.onchange=function () {
    if(leap && month==2)bDaySelect.remove(29);
    var year=bYearSelect.selectedOptions[0].value;
    leap=year%4==0;
    if(leap && month==2)bDaySelect.innerHTML+='<option value="29">29</option>';
};

bMonthSelect.onchange=function () {
    if(month==2){
        if(!leap)bDaySelect.innerHTML+='<option value="29">29</option>';
        bDaySelect.innerHTML+='<option value="30">30</option>';
        bDaySelect.innerHTML+='<option value="31">31</option>';
    }
    else if(month==4||month==6||month==9||month==11)
        bDaySelect.innerHTML+='<option value="31">31</option>';
    month=bMonthSelect.selectedOptions[0].value;
    if(month==4||month==6||month==9||month==11){
        bDaySelect.remove(31);
    }
    else if(month==2){
        bDaySelect.remove(31);
        bDaySelect.remove(30);
        if(!leap)bDaySelect.remove(29);
    }
};
