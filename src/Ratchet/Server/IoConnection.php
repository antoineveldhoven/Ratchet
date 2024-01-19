<?php
namespace Ratchet\Server;

/**
 * {@inheritdoc}
 */
#[\AllowDynamicProperties]
class IoConnection implements \Ratchet\ConnectionInterface, \React\Socket\ConnectionInterface {
    /**
     * @var \React\Socket\ConnectionInterface
     */
    protected $conn;

    /**
     * @param \React\Socket\ConnectionInterface $conn
     */
    public function __construct(\React\Socket\ConnectionInterface $conn) {
        $this->conn = $conn;
        $this->resourceId = (int)$conn->stream;
        $uri = $this->getRemoteAddress();
        $this->remoteAddress = trim(
            parse_url((strpos($uri, '://') === false ? 'tcp://' : '') . $uri, PHP_URL_HOST),
            '[]'
        );
    }
    
    /**
     * Ratchet\ConnectionInterface implementation
     */
    
    /**
     * {@inheritdoc}
     */
    public function send($data) {
        $this->conn->write($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function close() {
        return $this->conn->end();
    }
    
    /**
     * React\Socket\ConnectionInterface implementation
     */

    /**
     * {@inheritdoc}
     */
    public function emit($event, array $arguments = []) {
        return $this->conn->emit($event, $arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function end($data = null): void {
        $this->conn->end($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalAddress(): ?string {
        return $this->conn->getLocalAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function getRemoteAddress(): ?string {
        return $this->conn->getRemoteAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable(): bool {
        return $this->conn->isReadable();
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable(): bool {
        return $this->conn->isWritable();
    }

    /**
     * {@inheritdoc}
     */
    public function listeners($event = null) {
        return $this->conn->listeners($event);
    }

    /**
     * {@inheritdoc}
     */
    public function on($event, callable $listener) {
        return $this->conn->once($event, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function once($event, callable $listener) {
        return $this->conn->once($event, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function pause(): void {
        $this->conn->pause();
    }

    /**
     * {@inheritdoc}
     */
    public function pipe(\React\Stream\WritableStreamInterface $dest, array $options = []): \React\Stream\WritableStreamInterface {
        return $this->conn->pipe($dest, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAllListeners($event = null) {
        return $this->conn->removeAllListeners($event);
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener($event, callable $listener) {
        return $this->conn->removeListener($event, $listener);
    }

    /**
     * {@inheritdoc}
     */
    public function resume(): void {
        $this->conn->resume();
    }

    /**
     * {@inheritdoc}
     */
    public function write($data): bool {
        return $this->conn->write($data);
    }
}
