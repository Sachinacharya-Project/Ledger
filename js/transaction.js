const copyClipboard = (text)=>{
    const input = document.createElement("input")
    input.value = text
    input.classList.add("moveAway")
    document.body.appendChild(input)
    input.select()
    document.execCommand('copy')
    const notification = document.createElement("div")
    notification.classList.add('notification-trans')
    notification.textContent = "Copied to Clipboard"
    document.body.appendChild(notification)
    setTimeout(()=>{
        input.remove()
        notification.remove()
    }, 500)
}