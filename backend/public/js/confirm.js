function deleteHandle(event)
{
    // 一旦フォームをストップ
    event.preventDefault();
    if( window.confirm('本当に削除していいですか？') ) {
        document.getElementById('delete-form').submit();
        
    } else {
        alert('キャンセルしました');
    }
}

function createHandle(event)
{
    // 一旦フォームをストップする
    event.preventDefault();
    if( window.confirm('本当に登録してもいいですか？') ){
        document.getElementById('create-form').submit();
    } else {
        alert('キャンセルしました');
    }
}