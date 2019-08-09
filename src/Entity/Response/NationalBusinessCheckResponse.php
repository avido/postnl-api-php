<?php
declare(strict_types=1);
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2017-2019 Michael Dekker (https://github.com/firstred)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author    Michael Dekker <git@michaeldekker.nl>
 *
 * @copyright 2017-2019 Michael Dekker
 *
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Firstred\PostNL\Entity\Response;

use ArrayAccess;
use Countable;
use Firstred\PostNL\Entity\NationalBusinessCheckResult;
use Firstred\PostNL\Exception\InvalidArgumentException;
use Iterator;

/**
 * Class NationalBusinessCheckResponse
 */
class NationalBusinessCheckResponse extends AbstractResponse implements Iterator, ArrayAccess, Countable
{
    /**
     * Iterator index
     *
     * @var int $index
     *
     * @since 2.0.0
     */
    private $index = 0;

    /**
     * NationalBusinessCheckResults
     *
     * @pattern N/A
     *
     * @example N/A
     *
     * @var NationalBusinessCheckResult[] $results
     *
     * @since 2.0.0
     */
    protected $results = [];

    /**
     * Total amount of pages
     *
     * @var string|null $totalPages
     *
     * @since 2.0.0
     */
    protected $totalPages;

    /**
     * @var string|null $requestedPage
     *
     * @since 2.0.0
     */
    protected $requestedPage;

    /**
     * @var string|null $resultCount
     *
     * @since 2.0.0
     */
    protected $resultCount;

    /**
     * @var string|null $postnlKey
     *
     * @since 2.0.0
     */
    protected $postnlKey;

    /**
     * NationalBusinessCheckResponse constructor.
     *
     * @param NationalBusinessCheckResult[] $results
     *
     * @param string|null                   $totalPages
     * @param string|null                   $requestedPage
     * @param string|null                   $postnlKey
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public function __construct(array $results = [], ?string $totalPages = null, ?string $requestedPage = null, ?string $postnlKey = null)
    {
        parent::__construct();

        $this->setResults($results);
        $this->setTotalPages($totalPages);
        $this->setRequestedPage($requestedPage);
        $this->setPostnlKey($postnlKey);
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getTotalPages(): ?string
    {
        return $this->totalPages;
    }

    /**
     * @param string|null $totalPages
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setTotalPages(?string $totalPages): NationalBusinessCheckResponse
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getRequestedPage(): ?string
    {
        return $this->requestedPage;
    }

    /**
     * @param string|null $requestedPage
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setRequestedPage(?string $requestedPage): NationalBusinessCheckResponse
    {
        $this->requestedPage = $requestedPage;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getPostnlKey(): ?string
    {
        return $this->postnlKey;
    }

    /**
     * @param string|null $postnlKey
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setPostnlKey(?string $postnlKey): NationalBusinessCheckResponse
    {
        $this->postnlKey = $postnlKey;

        return $this;
    }

    /**
     * @return string|null
     *
     * @since 2.0.0
     */
    public function getResultCount(): ?string
    {
        return $this->resultCount;
    }

    /**
     * @param string|null $resultCount
     *
     * @return static
     *
     * @since 2.0.0
     */
    public function setResultCount(?string $resultCount): NationalBusinessCheckResponse
    {
        $this->resultCount = $resultCount;

        return $this;
    }

    /**
     * Get results
     *
     * @return NationalBusinessCheckResult[]|null
     *
     * @since 2.0.0
     *
     * @see NationalBusinessCheckResult
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * Set results
     *
     * @pattern N/A
     *
     * @param NationalBusinessCheckResult[]|null $results
     *
     * @return static
     *
     * @throws InvalidArgumentException
     *
     * @example N/A
     *
     * @since 2.0.0
     *
     * @see NationalBusinessCheckResult
     */
    public function setResults(?array $results = null): NationalBusinessCheckResponse
    {
        if (!empty($results) && !array_values($results)[0] instanceof NationalBusinessCheckResult) {
            throw new InvalidArgumentException(sprintf("%s::%s - Invalid NationalBusinessCheckResults array given", __CLASS__, __METHOD__));
        }

        $this->results = $results;

        return $this;
    }

    /**
     * Deserialize JSON
     *
     * @param array $json
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @since 2.0.0
     */
    public static function jsonDeserialize(array $json)
    {
        $object = new static();
        if (isset($json['NationalBusinessCheckResponse'])) {
            $value = $json['NationalBusinessCheckResponse'];
            $object->setTotalPages($value['totalPages'] ?? null);
            $object->setRequestedPage($value['requestedPage'] ?? null);
            $object->setResultCount($value['resultCount'] ?? null);
            $object->setPostnlKey($value['postnlKey'] ?? null);
            foreach ($value['result(s)'] as $result) {
                $object->results[] = NationalBusinessCheckResult::jsonDeserialize(['NationalBusinessCheckResult' => $result]);
            }
        }

        return $object;
    }

    /**
     * Return the current element
     *
     * @link  https://php.net/manual/en/iterator.current.php
     *
     * @return NationalBusinessCheckResult
     *
     * @since 2.0.0
     */
    public function current(): NationalBusinessCheckResult
    {
        return $this->results[$this->index];
    }

    /**
     * Move forward to next element
     *
     * @link  https://php.net/manual/en/iterator.next.php
     *
     * @return void Any returned value is ignored.
     *
     * @since 2.0.0
     */
    public function next()
    {
        if ($this->offsetExists($this->index + 1)) {
            $this->index++;
        }
    }

    /**
     * Return the key of the current element
     *
     * @link  https://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure.
     *
     * @since 2.0.0
     */
    public function key()
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->index;
    }

    /**
     * Checks if current position is valid
     *
     * @link  https://php.net/manual/en/iterator.valid.php
     *
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     *
     * @since 2.0.0
     */
    public function valid(): bool
    {
        return isset($this->results[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  https://php.net/manual/en/iterator.rewind.php
     *
     * @return void Any returned value is ignored.
     *
     * @since 2.0.0
     */
    public function rewind(): void
    {
        $this->index = 0;
    }

    /**
     * Whether a offset exists
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 2.0.0
     */
    public function offsetExists($offset): bool
    {
        return isset($this->results[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     *
     * @since 2.0.0
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->results[$offset];
        }

        return null;
    }

    /**
     * Offset to set
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     *
     * @since 2.0.0
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_null($offset)) {
            $this->results[$offset] = $value;
        } else {
            $this->results[] = $value;
        }
    }

    /**
     * Offset to unset
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     *
     * @since 2.0.0
     */
    public function offsetUnset($offset): void
    {
        unset($this->results[$offset]);
    }

    /**
     * Count elements of an object
     *
     * @link  https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     *
     * @since 2.0.0
     */
    public function count(): int
    {
        return count($this->results);
    }
}