import './bootstrap';
import 'preline';

document.addEventListener('livewire:navigated', () => {
   setTimeout(() => {
       window.HSStaticMethods.autoInit();
       // Specifically initialize the mobile menu if needed
       if (window.HSDrawer) {
           HSDrawer.autoInit();
       }
   }, 100);
});