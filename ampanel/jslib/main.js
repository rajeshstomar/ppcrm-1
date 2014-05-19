function Trim(str)
{
//	return str.replace(/^\s*([\S\s]*)\b\s*$/, '$1');
	return str.replace(/^\s*/, "").replace(/\s*$/, "");
}
function validate_email(address) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if(reg.test(address) == false) {
    	//alert('Please Enter Valid Email Address');
      return 0;
   }
   else
      return 1;          		
}
