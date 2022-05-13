function plural(num, text) {
	if (num > 1 || num == 0) return `${num} ${text}s`;

	return `${num} ${text}`;
}

var countdown = setInterval(function () {
	var now = new Date().getTime() / 1000;
	var remaining = date - now;

	var days = Math.floor(remaining / (60 * 60 * 24));
	var hours = Math.floor((remaining / (60 * 60)) % 24);
	var mins = Math.floor((remaining / 60) % 60);
	var secs = Math.floor(remaining % 60);

	var output = `${plural(days, "Day")}, ${plural(hours, "Hour")}, ${plural(
		mins,
		"Minute"
	)}, ${plural(secs, "Second")}`;

	document.getElementById("splitTimer").innerHTML = output;
}, 1000);
