import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import drawer from './drawer.js'

Alpine.data('drawer', drawer)

Livewire.start()