<label>{'Zip'|i18n( 'extension/all2egoogleweather' )}:</label>
{if is_set($attribute.content.1)}{$attribute.content.1}{/if}

<label>{'City'|i18n( 'extension/all2egoogleweather' )}:</label>
{if is_set($attribute.content.0)}{$attribute.content.0}{/if}

<label>{'Country'|i18n( 'extension/all2egoogleweather' )}:</label>
{if is_set($attribute.content.2)}{$attribute.content.2}{/if}


<fieldset>
    <legend>{'Today'|i18n( 'extension/all2egoogleweather' )}</legend>
    <table>
        <tr>
            <td><label>{'Condition'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($attribute.content.current_conditions.cur_condition)}{$attribute.content.current_conditions.cur_condition}{/if}</td>
        </tr>
        <tr>
            <td><label>{'Temperature'|i18n( 'extension/all2egoogleweather' )} {'(in Celsius)'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($attribute.content.current_conditions.cur_temp_c)}{$attribute.content.current_conditions.cur_temp_c}{/if}</td>
        </tr>
        <tr>
            <td><label>{'Humidity'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($attribute.content.current_conditions.cur_humidity)}{$attribute.content.current_conditions.cur_humidity}{/if}</td>
        </tr>
        <tr>
            <td><label>{'Icon'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($attribute.content.current_conditions.cur_icon)}<img src="http://www.google.com/ig{$attribute.content.current_conditions.cur_icon}" alt="weathericon" />{/if}</td>
        </tr>
    </table>
</fieldset>

{if $attribute.content.forecast|count()|gt(0)}
    <table><tr>
    {foreach $attribute.content.forecast as $forecast}
    <td>
        
<fieldset>
    <legend>{$forecast.day_of_week}</legend>
    <table>
        <tr>
            <td><label>{'Temperature'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($forecast.low)}{$forecast.low}{/if} - {if is_set($forecast.high)}{$forecast.high}{/if}</td>
        </tr>
        <tr>
            <td><label>{'Icon'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($forecast.icon)}<img src="http://www.google.com/ig{$forecast.icon}" alt="weathericon" />{/if}</td>
        </tr>
        <tr>
            <td><label>{'Condition'|i18n( 'extension/all2egoogleweather' )}:</label></td>
            <td>{if is_set($forecast.condition)}{$forecast.condition}{/if}</td>
        </tr>
    </table>
</fieldset>

    </td>
    {/foreach}
    </tr</table>
{/if}

{*$attribute.content.forecast|attribute(show)*}
