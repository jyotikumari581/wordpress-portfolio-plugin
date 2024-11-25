 function boffinportfoilovalidate() {
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
		 if (checkedOne == false) 
		 {	
			alert("Please Select Items");
			return false;
		 }
		 else
		 {
			 if (confirm('Are you sure?'))
			 {
				return true; 
			 }
			 else
			 {
				 return false;
			 }
		 }
    }
	
	function toggle(source) {
  checkboxes = document.getElementsByClassName('delete');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
	