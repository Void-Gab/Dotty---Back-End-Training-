<?php

// The Product interface declares the operations for all concrete product
interface Transport {

    public function ready() : void;

    public function dispatch() : void;

    public function deliver() : void;
}

// Concrete product providing implementations of Product interface
class PlaneTransport implements Transport {

    public function ready(): void {
        echo "Courier ready to be sent to the plane \n";
    }

    public function dispatch(): void {
        echo "Courier is on your way on the plane \n";
    }

    public function deliver(): void {
        echo "Courier from the plane is delivered to you \n";
    }
}

// Concrete product providing implementations of Product interface
class TruckTransport implements Transport {

    public function ready(): void {
        echo "Courier ready to be sent to the truck \n";
    }

    public function dispatch(): void {
        echo "Courier is on your way on the truck \n";
    }

    public function deliver(): void {
        echo "Courier from the truck is delivered to you \n";
    }
}

// The Creator class declares the factory method
abstract class Courier {

    // Factory method
    abstract function getCourierTransport() : Transport;

    public function sendCourier() {
        $transport = $this->getCourierTransport();
        $transport->ready();
        $transport->dispatch();
        $transport->deliver();
    }
}

// The Concrete Creator override the factory method and change the type of object created
class AirCourier extends Courier {

    function getCourierTransport(): Transport {
        return new PlaneTransport();
    }
}

// The Concrete Creator override the factory method and change the type of object created
class GroundCourier extends Courier {

    function getCourierTransport(): Transport {

        return new TruckTransport();
    }
}

// The client code works with an instance of concrete creator or subclass
function deliverCourier(Courier $courier) {
    $courier->sendCourier();
}

echo "Test Courier \n";
deliverCourier(new GroundCourier());

echo "Test Courier \n";
deliverCourier(new AirCourier());




