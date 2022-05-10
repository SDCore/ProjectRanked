timer();

function plural(num, text) {
	if (num > 1 || num == 0) return `${num} ${text}s`;

	return `${num} ${text}`;
}

function timer() {
	fetch("https://api.apexstats.dev/seasonInfo")
		.then((response) => response.json())
		.then((data) => {
			var time = new Date().getTime() / 1000;
			var end = data.dates.end - time;

			var days = Math.floor(end / (60 * 60 * 24));
			var hours = Math.floor(end / (60 * 60));
			var minutes = Math.floor((end / 60) % 60);
			var seconds = Math.floor(end % 60);

			var countdown = `${plural(days, "day")}, ${plural(
				hours,
				"hour"
			)}, ${plural(minutes, "minute")}, ${plural(seconds, "second")}`;

			document.getElementById("splitTime").innerHTML = countdown;

			setTimeout(timer, 1000);
		});
}
