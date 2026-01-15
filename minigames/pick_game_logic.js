function openModal(category) {
  const modal = document.getElementById('categoryModal');
  const container = document.getElementById('modalCardsContainer');
  container.innerHTML = '';

  for (let i = 1; i <= 13; i++) {
    const card = document.createElement('div');
    card.className = 'modal-card';

    const img = document.createElement('img');
    img.src = `../brinth_icons/${category}/image${i}.png`;
    img.alt = `${category} ${i}`;
    img.onclick = () => {
      // Only add error handler to Diamonds and Hearts
      if (category === 'diamonds' || category === 'hearts') {
        window.location.href = `../minigames/${category}/Brinth_G_${category}.php?game=${category}${i}`;
      } else {
        window.location.href = `../minigames/${category}/${category}${i}.php`;
      }
    };

    card.appendChild(img);
    container.appendChild(card);
  }

  modal.style.display = 'block';
}

function closeModal() {
  document.getElementById('categoryModal').style.display = 'none';
}
