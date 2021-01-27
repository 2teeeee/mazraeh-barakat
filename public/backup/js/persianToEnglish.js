
$( ".persian-number" ).keyup(function() {
    $(this).val(convertToEnglish($(this).val()));
});

function convertToEnglish(text){
        text = text.replace(String.fromCharCode(1777), "1");
        text = text.replace(String.fromCharCode(1778), "2");
        text = text.replace(String.fromCharCode(1779), "3");
        text = text.replace(String.fromCharCode(1780), "4");
        text = text.replace(String.fromCharCode(1781), "5");
        text = text.replace(String.fromCharCode(1782), "6");
        text = text.replace(String.fromCharCode(1783), "7");
        text = text.replace(String.fromCharCode(1784), "8");
        text = text.replace(String.fromCharCode(1785), "9");
        text = text.replace(String.fromCharCode(1776), "0");
        
        text = text.replace(String.fromCharCode(1633), "1");
        text = text.replace(String.fromCharCode(1634), "2");
        text = text.replace(String.fromCharCode(1635), "3");
        text = text.replace(String.fromCharCode(1636), "4");
        text = text.replace(String.fromCharCode(1637), "5");
        text = text.replace(String.fromCharCode(1638), "6");
        text = text.replace(String.fromCharCode(1639), "7");
        text = text.replace(String.fromCharCode(1640), "8");
        text = text.replace(String.fromCharCode(1641), "9");
        text = text.replace(String.fromCharCode(1632), "0");

        return text;
  };