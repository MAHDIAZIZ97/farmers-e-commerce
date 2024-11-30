import './bootstrap';
import 'preline';

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.auto Init();
})
