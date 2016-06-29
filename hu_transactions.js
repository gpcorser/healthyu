// on create: trans_date defaults to today 
function calcDate() {
	var today = new Date();
	var dd = today.getDate();
	if (dd < 10) dd = "0" + dd;
	var mm = 1 + today.getMonth(); 
	if (mm < 10) mm = "0" + mm;
	var yyyy = today.getFullYear();
	document.getElementById("trans_date").value = yyyy + "-" + mm + "-" + dd;
}

// exercise yields 5 points for every 30 minutes.
function calcExercisePoints() {
	document.getElementById("trans_exercise_points").value 
		= Math.floor(document.getElementById("minutes").value / 30) * 5;
	// code below is useful if a specific transaction generates bonus points based on checkbox
	document.getElementById("trans_points").value 
		= Math.floor(document.getElementById("trans_exercise_points").value)
		+ 0 * (trans_hu_activity_clicked + trans_strength_activity_clicked + trans_fitness_class_clicked);
}

// set variables for transaction checkboxes (see: function calcExercisePoints()
var trans_hu_activity_clicked = 0; 
var trans_strength_activity_clicked = 0;
var trans_fitness_class_clicked = 0;
function trans_hu_activity_click () {
	if (trans_hu_activity_clicked == 0) trans_hu_activity_clicked = 1;
	else trans_hu_activity_clicked = 0;
}
function trans_strength_activity_click () {
	if (trans_strength_activity_clicked == 0) trans_strength_activity_clicked = 1;
	else trans_strength_activity_clicked = 0;
}
function trans_fitness_class_click () {
	if (trans_fitness_class_clicked == 0) trans_fitness_class_clicked = 1;
	else trans_fitness_class_clicked = 0;
}
