<div class="weekly-heading month-left">
    @include('frontend.partials.svg.icons.arrow-left')
    <p>October 2020</p>
    @include('frontend.partials.svg.icons.arrow-right')
</div>
<div class="calendar-wrap">
    <table>
        <thead>
            <tr>
                <th>{{ __('DAY_MONDAY_SHORT') }}</th>
                <th>{{ __('DAY_TUESDAY_SHORT') }}</th>
                <th>{{ __('DAY_WEDNESDAY_SHORT') }}</th>
                <th>{{ __('DAY_THURSDAY_SHORT') }}</th>
                <th>{{ __('DAY_FRIDAY_SHORT') }}</th>
                <th>{{ __('DAY_SATURDAY_SHORT') }}</th>
                <th>{{ __('DAY_SUNDAY_SHORT') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span></span></td>
                <td><span></span></td>
                <td><span>1</span><span>&nbsp;</span></td>
                <td><span>2</span></td>
                <td><span>3</span></td>
                <td><span>4</span></td>
                <td><span>5</span></td>
            </tr>
            <tr>
                <td><span>6</span><span>&nbsp;</span></td>
                <td><span>7</span></td>
                <td><span>8</span></td>
                <td><span>9</span></td>
                <td><span>10</span></td>
                <td><span>11</span></td>
                <td><span>12</span></td>
            </tr>
            <tr class="activate-date-no">
                <td><span>13</span><span class="booking-date">+3</span></td>
                <td><span>14</span><span class="booking-date">+4</span></td>
                <td><span>15</span><span class="booking-date">+2</span></td>
                <td class="selected"><span>16</span><span class="booking-date">+3</span></td>
                <td><span>17</span><span class="booking-date">+4</span></td>
                <td><span>18</span></td>
                <td><span>19</span></td>
            </tr>
            <tr>
                <td><span>20</span><span>&nbsp;</span></td>
                <td><span>21</span></td>
                <td><span>22</span></td>
                <td><span>23</span></td>
                <td><span>24</span></td>
                <td><span>25</span></td>
                <td><span>26</span></td>
            </tr>
            <tr>
                <td><span>27</span><span>&nbsp;</span></td>
                <td><span>28</span></td>
                <td><span>29</span></td>
                <td><span>30</span></td>
                <td><span>31</span></td>
                <td><span></span></td>
                <td><span></span></td>
            </tr>
        </tbody>
    </table>
</div>
