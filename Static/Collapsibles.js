function PageInit() {
	const Cs = document.getElementsByClassName("COLLAPSIBLE");

	for (let i = 0; i < Cs.length; i++) {
		Cs[i].setAttribute("data-collapsed", "");

		Cs[i].children[0].addEventListener("click", function() {
			let x = Cs[i].getAttribute("data-collapsed") !== null;
			
			if (x) {
				Cs[i].removeAttribute("data-collapsed");
			} else {
				Cs[i].setAttribute("data-collapsed", "");
			}
		});
	}
}