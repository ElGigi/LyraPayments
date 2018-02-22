<?php
/**
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2018 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace ElGigi\LyraPayments;

use ElGigi\LyraPayments\Exception\LyraPaymentsException;

/**
 * Class AbstractObject.
 *
 * @package ElGigi\LyraPayments
 */
abstract class AbstractObject
{
    /** @var array Data declaration */
    private $dataDeclaration = [];
    /** @var array Data values */
    private $data = [];

    /**
     * AbstractObject constructor.
     *
     * @param string[] $dataDeclaration Array of variables (example: ['reference': 'n..80', 'title' => '[PRIVATE,COMPANY]'])
     * @param array    $data            Default data
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __construct(array $dataDeclaration, array $data = [])
    {
        $this->dataDeclaration = $dataDeclaration;

        // Set default data
        $this->setData($data);
    }

    /**
     * __set_state() magic method.
     *
     * @return array
     */
    public function __set_state(): array
    {
        $vars = [];

        foreach ($this->data as $key => $value) {
            if ($value instanceof AbstractObject) {
                $vars[$key] = $value->__set_state();
            } else {
                $vars[$key] = $value;
            }
        }

        return $vars;
    }

    /**
     * __debugInfo() magic method.
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        $vars = [];

        foreach ($this->dataDeclaration as $key => $type) {
            if (array_key_exists($key, $this->data)) {
                if ($this->data[$key] instanceof AbstractObject) {
                    $vars[$key] = $this->data[$key]->__set_state();
                } else {
                    $vars[$key] = $this->data[$key];
                }
            } else {
                $vars[$key] = null;
            }
        }

        return $vars;
    }

    /**
     * __get() magic method.
     *
     * @param string $name
     *
     * @return mixed
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->dataDeclaration)) {
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            } else {
                return null;
            }
        } else {
            throw new LyraPaymentsException(sprintf('Undefined variable "%s" in class "%s"', $name, get_class($this)));
        }
    }

    /**
     * __set() magic method.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function __set(string $name, $value)
    {
        if (array_key_exists($name, $this->dataDeclaration)) {
            if ($this::controlFormat($this->dataDeclaration[$name], $value)) {
                $this->data[$name] = $value;
            } else {
                throw new LyraPaymentsException(sprintf('Bad format for property "%s" (%s) in class "%s", %s given.',
                                                        $name, $this->dataDeclaration[$name], get_class($this), (is_object($value) ? get_class($value) : '"' . $value . '"')));
            }
        } else {
            throw new LyraPaymentsException(sprintf('Undefined property "%s" in class "%s", or readonly.', $name, get_class($this)));
        }
    }

    /**
     * Get value of variable.
     *
     * @param string $name
     *
     * @return mixed
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function get(string $name)
    {
        return $this->__get($name);
    }

    /**
     * Set data.
     *
     * @param array $data
     *
     * @return \ElGigi\LyraPayments\AbstractObject
     * @throws \ElGigi\LyraPayments\Exception\LyraPaymentsException
     */
    public function setData(array $data): AbstractObject
    {
        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }

        return $this;
    }

    /**
     * Control format.
     *
     * @param string        $type  Type of variable
     * @param string|object $value Value to control
     *
     * @return bool
     */
    public static function controlFormat(string $type, $value): bool
    {
        if (is_object($value)) {
            return is_subclass_of($type, __CLASS__) && is_a($value, $type);
        } else {
            switch ($type) {
                case 'bool':
                    return is_bool($value);
                case 'datetime':
                    return preg_match('/([0-2][0-9]{3})\-([0-1][0-9])\-([0-3][0-9])T([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])(Z|([\-\+]([0-1][0-9])\:00))/', $value) == 1;
                case 'int':
                    return is_int($value);
                case 'long':
                    return is_long($value);
                case 'string':
                    return is_string($value);
                default:
                    $match = [];
                    if (preg_match('/^([ans]{1,3})((\.\.)?([0-9]+))$/i', $type, $match)) {
                        $regexControl = '[' .
                                        (stripos($match[1], 'a') !== false ? 'a-z' : '') .
                                        (stripos($match[1], 'n') !== false ? '0-9' : '') .
                                        (stripos($match[1], 's') !== false ? '\V' : '') .
                                        ']' .
                                        '{' .
                                        (!empty($match[3]) ? '1,' : '') .
                                        $match[4] .
                                        '}';

                        return preg_match('/^' . $regexControl . '$/iu', $value) == 1;
                    } else {
                        if (preg_match('/^\[(.*)\]/', $type, $match)) {
                            return in_array($value, array_map('trim', explode(',', $match[1])));
                        }
                    }
            }
        }

        return false;
    }
}