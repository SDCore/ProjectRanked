function plural(num, text) {
	if (num > 1 || num == 0) return `${num} ${text}s`;

	return `${num} ${text}`;
}

var timer = setInterval(function () {
	var now = new Date().getTime() / 1000;
	var start = now - matchLength;

	var mins = Math.floor((start / 60) % 60);
	var secs = Math.floor(start % 60);

	var output = `${mins}m ${secs}s`;

	document.getElementById("userTime").innerHTML = output;
}, 1000);
