// 定数btnを宣言
const btn = document.querySelector('.button');

btn.addEventListener('click', (event) => {
  // 定数isYesを宣言 
  const isYes = confirm('投稿してよろしいですか？');
  document.querySelector().innerHTML = isYes;
  event.preventDefault();
}, false);



