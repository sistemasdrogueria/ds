<style>
	.imagenlocation {
		position: relative;
		width: 100%;
	}

	.title {
		position: absolute;
		top: 35%;
		left: 57%;
		transform: translate(-50%, -50%);
		font-size: 2rem;
		font-weight: bold;
		color: #ffffff;
		text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
		white-space: nowrap;
	}

	.cursor {
		display: inline-block;
		width: 3px;
		height: 1.2em;
		background-color: white;
		margin-left: 2px;
		animation: blink 0.7s infinite;
	}

	@media (max-width: 768px) {
		.title {
			font-size: 15px;
			top: 60%;
			left: 5%;
			transform: translateX(0);
			color: #0040ff;
			background-color: #ffffffab;
		}
	}

	@keyframes blink {
		0% {
			opacity: 0;
		}

		50% {
			opacity: 1;
		}

		100% {
			opacity: 0;
		}
	}
</style>

<div class="imagenlocation">
	<img id="responsive-image" alt="Sur Noticias" class="full-width-divider">
	<h5 id="typing-text" class="title"></h5>
</div>


<script>
	const text = 'Sur Noticias - Te acercamos a las novedades';
	let index = 0;
	const typingElement = document.getElementById('typing-text');

	function typeText() {
		if (index < text.length) {
			if (Math.random() < 0.0) { // Se puede agregar para que tipee mal
				const wrongChar = String.fromCharCode(
					text.charCodeAt(index) + (Math.random() > 0.5 ? 1 : -1)
				);
				typingElement.innerHTML += wrongChar;
				setTimeout(() => {
					typingElement.innerHTML = typingElement.innerHTML.slice(0, -1) + text[index];
					index++;
					setTimeout(typeText, 60);
				}, 100);
			} else {
				typingElement.innerHTML = text.slice(0, index + 1);
				index++;
				setTimeout(typeText, 60);
			}
		}
	}
	typeText();
</script>